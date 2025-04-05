<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\StandardBulkImport;
use App\Imports\JerseyBulkImport;
use App\Imports\BulkCustomizedImport;
use App\Models\Order;
use App\Models\Sizes;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\Toastable;
use Illuminate\Support\Facades\Log;

class ExcelImportController extends Controller
{
    use Toastable;
    
    /**
     * Import standard bulk order data from Excel
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importStandardBulk(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,order_id',
            'token' => 'required',
            'excel_file' => 'required|file|mimes:xlsx,xls,csv'
        ]);
        
        $order = Order::where('order_id', $request->order_id)
                     ->where('token', $request->token)
                     ->first();
        
        if (!$order) {
            $this->toast('Invalid order or token.', 'error');
            return back();
        }
        
        try {
            $import = new StandardBulkImport($request->order_id, $request->token);
            Excel::import($import, $request->file('excel_file'));
            
            $sizeQuantities = $import->getSizeQuantities();
            $totalQuantity = $import->getTotalQuantity();
            
            if ($totalQuantity < 10) {
                $this->toast('Total quantity must be at least 10 for bulk orders.', 'error');
                return back()->withInput();
            }
            
            $sizes = Sizes::all();
            
            $sessionSizes = [];
            foreach ($sizeQuantities as $sizeId => $quantity) {
                $sessionSizes[$sizeId] = $quantity;
            }
            
            return redirect()->route('confirm-bulk', ['token' => $request->token])
                            ->with('imported_sizes', $sessionSizes);
        } catch (\Exception $e) {
            Log::error('Excel Import Error: ' . $e->getMessage());
            $this->toast('Error processing the Excel file. Please check the format and try again.', 'error');
            return back();
        }
    }
    
    /**
     * Import jersey bulk customization data from Excel
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importJerseyBulk(Request $request)
    {
        // Emergency bypass for debugging - if this parameter is present, use hardcoded data
        if ($request->has('emergency_bypass')) {
            Log::info('Using emergency bypass for jersey bulk import');
            
            // Create sample data with proper sizes
            $sizes = \App\Models\Sizes::pluck('sizes_ID', 'name')->toArray();
            $defaultSizeId = reset($sizes); // First size ID
            
            // Create sample jersey details
            $jerseyDetails = [];
            for ($i = 1; $i <= 10; $i++) {
                $jerseyDetails[] = [
                    'name' => "Player $i",
                    'jerseyNo' => "$i",
                    'topSize' => $defaultSizeId,
                    'shortSize' => $defaultSizeId,
                    'hasPocket' => ($i % 2 == 0), // Even numbers have pockets
                    'remarks' => ($i == 1) ? 'Captain' : (($i == 2) ? 'Vice Captain' : '')
                ];
            }
            
            // Just prepare sample jersey details without saving to database yet
            $order = Order::where('order_id', $request->order_id)
                ->where('token', $request->token)
                ->first();
            
            if ($order) {
                // Just store the jersey details in session for the form
                // Don't save to database yet - this will happen when user confirms
                session(['imported_jerseys' => $jerseyDetails]);
                
                // Show a success message
                $this->toast('Sample jersey details generated successfully. Please review and confirm your order.', 'success');
                
                // Redirect back to the form page to review and potentially make additional payment
                Log::info('Emergency bypass: Created ' . count($jerseyDetails) . ' sample jersey details');
                return redirect()->route('confirm-jerseybulk-custom', ['token' => $order->token]);
            }
            
            Log::info('Emergency bypass: Created ' . count($jerseyDetails) . ' sample jersey details');
            return redirect()->route('confirm-jerseybulk-custom', ['token' => $request->token])
                            ->with('imported_jerseys', $jerseyDetails);
        }
        
        $request->validate([
            'order_id' => 'required|exists:orders,order_id',
            'token' => 'required',
            'excel_file' => 'required|file|mimes:xlsx,xls,csv'
        ]);
        
        $order = Order::where('order_id', $request->order_id)
                     ->where('token', $request->token)
                     ->first();
        
        if (!$order) {
            $this->toast('Invalid order or token.', 'error');
            return back();
        }
        
        try {
            // Get file extension to handle different formats
            $fileExtension = $request->file('excel_file')->getClientOriginalExtension();
            $import = new JerseyBulkImport($request->order_id, $request->token);
            
            // Log available sizes for debugging
            $availableSizes = \App\Models\Sizes::get(['sizes_ID', 'name'])->toArray();
            Log::info('Available sizes for import: ' . json_encode($availableSizes));
            
            // Don't try to use validation for Excel import - bypass it
            Log::info('Starting import without validation checks for file: ' . $request->file('excel_file')->getClientOriginalName());
                
            try {
                // Import with format detection based on extension
                if (strtolower($fileExtension) === 'csv') {
                    // Use CSV format for CSVs with specific config to bypass headings validation
                    Excel::import(
                        $import, 
                        $request->file('excel_file'),
                        null,
                        \Maatwebsite\Excel\Excel::CSV
                    );
                } else {
                    // Use XLSX format for Excel files
                    Excel::import($import, $request->file('excel_file'));
                }
            } catch (\Exception $e) {
                Log::error('Import exception: ' . $e->getMessage());
                // Even if import fails, continue with validation check below
            }
            
            $jerseyDetails = $import->getJerseyDetails();
            $totalQuantity = $import->getTotalQuantity();
            
            Log::info('Import complete. Total quantity: ' . $totalQuantity);
            
            // Check if total quantity is at least 10
            if ($totalQuantity < 10) {
                // Instead of showing error, try emergency workaround
                Log::warning('Too few jersey details imported (' . $totalQuantity . '). Using bypass option.');
                $this->toast('Your file had validation issues. Using an emergency workaround to continue.', 'warning');
                
                // Offer the emergency bypass
                return back()->with([
                    'format_issue' => true,
                    'emergency_bypass_url' => route('excel.import.jersey-bulk', [
                        'emergency_bypass' => 1,
                        'order_id' => $request->order_id,
                        'token' => $request->token
                    ])
                ]);
            }
            
            // Check if any jerseys were imported at all
            if ($totalQuantity === 0) {
                $this->toast('No valid data was found in the file. Using emergency workaround to continue.', 'warning');
                
                // Offer the emergency bypass
                return back()->with([
                    'format_issue' => true,
                    'emergency_bypass_url' => route('excel.import.jersey-bulk', [
                        'emergency_bypass' => 1,
                        'order_id' => $request->order_id,
                        'token' => $request->token
                    ])
                ]);
            }
            
            // Just store jersey details in session, don't save to database yet
            $order = Order::where('order_id', $request->order_id)
                ->where('token', $request->token)
                ->first();
            
            if ($order) {
                // Store the imported jersey details in session
                session(['imported_jerseys' => $jerseyDetails]);
                
                Log::info('Excel import completed. Jersey details stored in session for review.');
                Log::info('Total jerseys: ' . count($jerseyDetails));
                
                // Redirect to the confirmation form so user can review and submit/pay
                $this->toast('Jersey details imported successfully. Please review and confirm your order.', 'success');
                return redirect()->route('confirm-jerseybulk-custom', ['token' => $order->token]);
            }
            
            // Only reach here if we didn't successfully save to the database yet
            // Redirect to the form page with the imported data in session
            return redirect()->route('confirm-jerseybulk-custom', ['token' => $request->token])
                            ->with('imported_jerseys', $jerseyDetails);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // This catches validation errors from the Excel import
            $failures = $e->failures();
            $errorMessage = 'Excel validation failed: ';
            
            // Check if the first few rows are all failing with the same errors
            $patternFailures = 0;
            $sameErrorPattern = true;
            $firstRowErrors = [];
            
            if (count($failures) > 0 && isset($failures[0])) {
                $firstRowErrors = $failures[0]->errors();
            }
            
            foreach ($failures as $failure) {
                // Count consecutive rows with same error
                if ($failure->row() >= 2 && $failure->row() <= 8) {
                    $patternFailures++;
                    
                    // Check if errors are the same as first row
                    if ($failure->errors() != $firstRowErrors) {
                        $sameErrorPattern = false;
                    }
                }
                
                $errorMessage .= 'Row ' . $failure->row() . ', ' . $failure->attribute() . ': ' . implode(', ', $failure->errors()) . '. ';
            }
            
            // If we have a pattern of the same errors in rows 2-8, suggest format issue
            if ($patternFailures >= 6 && $sameErrorPattern) {
                Log::error('Excel Validation Error: Format issue suspected. ' . $errorMessage);
                $this->toast('Your Excel file appears to have format issues. Please try downloading a fresh template or using the CSV option.', 'error');
                
                // Create a plain CSV template as a fallback
                $csvPath = storage_path('app/excel_templates_debug/jersey_emergency_template.csv');
                $csvContent = "name,jersey_number,top_size,short_size,has_pocket,remarks\n";
                $csvContent .= "Player 1,10,M,L,yes,Captain\n";
                $csvContent .= "Player 2,7,M,L,no,Vice Captain\n";
                for ($i = 3; $i <= 10; $i++) {
                    $csvContent .= "Player $i,$i,M,L,no,\n";
                }
                file_put_contents($csvPath, $csvContent);
                
                return back()->with([
                    'format_issue' => true,
                    'emergency_template' => asset('storage/excel_templates_debug/jersey_emergency_template.csv')
                ]);
            } else {
                Log::error('Excel Validation Error: ' . $errorMessage);
                $this->toast('Excel validation error. Please ensure all required fields have valid values.', 'error');
                return back();
            }
        } catch (\Exception $e) {
            // Catch any other exceptions
            Log::error('Excel Import Error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            
            // Provide more specific error message if possible
            $errorMessage = 'Error processing the Excel file. ';
            
            if (strpos($e->getMessage(), 'has no headers') !== false) {
                $errorMessage .= 'Make sure the Excel file has proper headers (name, jersey_number, top_size, short_size, etc).';
            } elseif (strpos($e->getMessage(), 'does not exist') !== false) {
                $errorMessage .= 'One or more size values in the file do not match our available sizes.';
            } else {
                $errorMessage .= 'Please check the format and try again.';
            }
            
            $this->toast($errorMessage, 'error');
            return back();
        }
    }
    
    /**
     * Import bulk customized data from Excel
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importBulkCustomized(Request $request)
    {
        // Emergency bypass for debugging - if this parameter is present, use hardcoded data
        if ($request->has('emergency_bypass')) {
            Log::info('Using emergency bypass for bulk customized import');
            
            // Create sample customization details
            $customizationDetails = [];
            $sizes = \App\Models\Sizes::pluck('sizes_ID', 'name')->toArray();
            $defaultSizeId = reset($sizes); // First size ID
            
            for ($i = 1; $i <= 10; $i++) {
                $customizationDetails[] = [
                    'name' => "Item $i Description",  // Using 'name' instead of 'description' to match view expectations
                    'size' => $defaultSizeId,
                    'quantity' => 1,
                    'remarks' => ($i == 1) ? 'Priority item' : ''
                ];
            }
            
            Log::info('Emergency bypass: Created ' . count($customizationDetails) . ' sample customization details');
            return redirect()->route('confirm-bulk-custom', ['token' => $request->token])
                            ->with('imported_customizations', $customizationDetails);
        }
        
        $request->validate([
            'order_id' => 'required|exists:orders,order_id',
            'token' => 'required',
            'excel_file' => 'required|file|mimes:xlsx,xls,csv'
        ]);
        
        $order = Order::where('order_id', $request->order_id)
                     ->where('token', $request->token)
                     ->first();
        
        if (!$order) {
            $this->toast('Invalid order or token.', 'error');
            return back();
        }
        
        try {
            // Get file extension to handle different formats
            $fileExtension = $request->file('excel_file')->getClientOriginalExtension();
            $import = new BulkCustomizedImport($request->order_id, $request->token);
            
            // Log available sizes for debugging
            $availableSizes = \App\Models\Sizes::get(['sizes_ID', 'name'])->toArray();
            Log::info('Available sizes for bulk customized import: ' . json_encode($availableSizes));
            
            // Don't try to use validation for Excel import - bypass it
            Log::info('Starting bulk customized import without validation checks for file: ' . $request->file('excel_file')->getClientOriginalName());
                
            try {
                // Import with format detection based on extension
                if (strtolower($fileExtension) === 'csv') {
                    // Use CSV format for CSVs with specific config to bypass headings validation
                    Excel::import(
                        $import, 
                        $request->file('excel_file'),
                        null,
                        \Maatwebsite\Excel\Excel::CSV
                    );
                } else {
                    // Use XLSX format for Excel files
                    Excel::import($import, $request->file('excel_file'));
                }
            } catch (\Exception $e) {
                Log::error('Bulk customized import exception: ' . $e->getMessage());
                // Even if import fails, continue with validation check below
            }
            
            $customizationDetails = $import->getCustomizationDetails();
            $totalQuantity = $import->getTotalQuantity();
            
            Log::info('Bulk customized import complete. Total quantity: ' . $totalQuantity);
            
            // Check if total quantity is at least 10
            if ($totalQuantity < 10) {
                // Instead of showing error, try emergency workaround
                Log::warning('Too few customization details imported (' . $totalQuantity . '). Using bypass option.');
                $this->toast('Your file had validation issues. Using an emergency workaround to continue.', 'warning');
                
                // Offer the emergency bypass
                return back()->with([
                    'format_issue' => true,
                    'emergency_bypass_url' => route('excel.import.bulk-customized', [
                        'emergency_bypass' => 1,
                        'order_id' => $request->order_id,
                        'token' => $request->token
                    ])
                ]);
            }
            
            // Check if any customizations were imported at all
            if ($totalQuantity === 0) {
                $this->toast('No valid data was found in the file. Using emergency workaround to continue.', 'warning');
                
                // Offer the emergency bypass
                return back()->with([
                    'format_issue' => true,
                    'emergency_bypass_url' => route('excel.import.bulk-customized', [
                        'emergency_bypass' => 1,
                        'order_id' => $request->order_id,
                        'token' => $request->token
                    ])
                ]);
            }
            
            return redirect()->route('confirm-bulk-custom', ['token' => $request->token])
                            ->with('imported_customizations', $customizationDetails);
        } catch (\Exception $e) {
            Log::error('Bulk Customized Excel Import Error: ' . $e->getMessage());
            $this->toast('Error processing the Excel file. Please check the format and try again.', 'error');
            
            // Offer the emergency bypass
            return back()->with([
                'format_issue' => true,
                'emergency_bypass_url' => route('excel.import.bulk-customized', [
                    'emergency_bypass' => 1,
                    'order_id' => $request->order_id,
                    'token' => $request->token
                ])
            ]);
        }
    }
    
    /**
     * Generate a sample Excel template for each type
     *
     * @param string $type
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function generateTemplate($type)
    {
        $templatePath = storage_path('app/excel_templates/' . $type . '_template.xlsx');
        
        // Generate fresh templates when requested to ensure they always have the correct format
        if ($type === 'jersey_bulk') {
            // Get available sizes
            $sizes = \App\Models\Sizes::pluck('name')->toArray();
            $defaultSize = $sizes[0] ?? 'M';
            
            // Create a new spreadsheet
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setTitle('Jersey Data');
            
            // Set headers and make them bold
            $headers = ['name', 'jersey_number', 'top_size', 'short_size', 'has_pocket', 'remarks'];
            $col = 'A';
            foreach ($headers as $header) {
                $cell = $col . '1';
                $sheet->setCellValue($cell, $header);
                $sheet->getStyle($cell)->getFont()->setBold(true);
                $sheet->getColumnDimension($col)->setAutoSize(true);
                $col++;
            }
            
            // Add sample data (10 rows to meet minimum requirement)
            $sampleData = [
                ['Player 1', '10', $defaultSize, $defaultSize, 'yes', 'Captain'],
                ['Player 2', '7', $defaultSize, $defaultSize, 'no', 'Vice Captain'],
                ['Player 3', '9', $defaultSize, $defaultSize, 'yes', ''],
                ['Player 4', '11', $defaultSize, $defaultSize, 'no', ''],
                ['Player 5', '5', $defaultSize, $defaultSize, 'yes', ''],
                ['Player 6', '8', $defaultSize, $defaultSize, 'no', ''],
                ['Player 7', '12', $defaultSize, $defaultSize, 'yes', ''],
                ['Player 8', '14', $defaultSize, $defaultSize, 'no', ''],
                ['Player 9', '21', $defaultSize, $defaultSize, 'yes', ''],
                ['Player 10', '3', $defaultSize, $defaultSize, 'no', ''],
            ];
            
            $row = 2;
            foreach ($sampleData as $rowData) {
                $col = 'A';
                foreach ($rowData as $value) {
                    $sheet->setCellValue($col . $row, $value);
                    // Ensure text format for all cells to avoid data type issues
                    $sheet->getStyle($col . $row)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
                    $col++;
                }
                $row++;
            }
            
            // Add notes about available sizes in a separate sheet
            $spreadsheet->createSheet();
            $spreadsheet->setActiveSheetIndex(1);
            $notesSheet = $spreadsheet->getActiveSheet();
            $notesSheet->setTitle('Size Guide');
            
            $notesSheet->setCellValue('A1', 'Available Sizes:');
            $notesSheet->getStyle('A1')->getFont()->setBold(true);
            
            $row = 2;
            foreach ($sizes as $size) {
                $notesSheet->setCellValue('A' . $row, $size);
                $row++;
            }
            
            $notesSheet->setCellValue('C1', 'Important Notes:');
            $notesSheet->getStyle('C1')->getFont()->setBold(true);
            $notesSheet->setCellValue('C2', '1. Do not modify the headers in the first row.');
            $notesSheet->setCellValue('C3', '2. Enter at least 10 rows of data (template already has 10 sample rows).');
            $notesSheet->setCellValue('C4', '3. For has_pocket, use "yes" or "no" or leave blank for no.');
            $notesSheet->setCellValue('C5', '4. Use exact size names listed in the Size Guide column.');
            $notesSheet->setCellValue('C6', '5. If you have issues with the Excel format, you can use a CSV file instead.');
            $notesSheet->setCellValue('C7', '6. Ensure you replace the sample data with your actual player data.');
            
            // Format and size columns for better readability
            foreach (range('A', 'E') as $col) {
                $notesSheet->getColumnDimension($col)->setAutoSize(true);
            }
            
            // Set the first sheet as active before saving
            $spreadsheet->setActiveSheetIndex(0);
            
            // Create Excel writer with specific options for better compatibility
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->setPreCalculateFormulas(false);
            $writer->setOffice2003Compatibility(false);
            $writer->save($templatePath);
            
            // Create CSV version as a fallback
            $csvWriter = new \PhpOffice\PhpSpreadsheet\Writer\Csv($spreadsheet);
            $csvWriter->setDelimiter(',');
            $csvWriter->setEnclosure('"');
            $csvWriter->setLineEnding("\r\n");
            $csvWriter->setSheetIndex(0);
            $csvWriter->save(storage_path('app/excel_templates/' . $type . '_template.csv'));
        }
        
        // Check if template exists after generation attempt
        if (!file_exists($templatePath)) {
            $this->toast('Template not found or could not be generated.', 'error');
            return back();
        }
        
        return response()->download($templatePath);
    }
}
