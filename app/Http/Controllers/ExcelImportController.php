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
            $import = new JerseyBulkImport($request->order_id, $request->token);
            Excel::import($import, $request->file('excel_file'));
            
            $jerseyDetails = $import->getJerseyDetails();
            $totalQuantity = $import->getTotalQuantity();
            
            // Check if total quantity is at least 10
            if ($totalQuantity < 10) {
                $this->toast('You must specify at least 10 jerseys for bulk orders.', 'error');
                return back()->withInput();
            }
            
            // Check if any jerseys were imported at all
            if ($totalQuantity === 0) {
                $this->toast('No valid data was found in the Excel file. Please ensure the file has the correct format with headers: name, jersey_number, top_size, short_size.', 'error');
                return back();
            }
            
            return redirect()->route('confirm-jerseybulk-custom', ['token' => $request->token])
                            ->with('imported_jerseys', $jerseyDetails);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // This catches validation errors from the Excel import
            $failures = $e->failures();
            $errorMessage = 'Excel validation failed: ';
            
            foreach ($failures as $failure) {
                $errorMessage .= 'Row ' . $failure->row() . ', ' . $failure->attribute() . ': ' . implode(', ', $failure->errors()) . '. ';
            }
            
            Log::error('Excel Validation Error: ' . $errorMessage);
            $this->toast('Excel validation error. Please ensure all required fields have valid values.', 'error');
            return back();
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
            $import = new BulkCustomizedImport($request->order_id, $request->token);
            Excel::import($import, $request->file('excel_file'));
            
            $customizationDetails = $import->getCustomizationDetails();
            $totalQuantity = $import->getTotalQuantity();
            
            // Check if total quantity is at least 10
            if ($totalQuantity < 10) {
                $this->toast('You must specify at least 10 customizations for bulk orders.', 'error');
                return back()->withInput();
            }
            
            return redirect()->route('confirm-bulk-custom', ['token' => $request->token])
                            ->with('imported_customizations', $customizationDetails);
        } catch (\Exception $e) {
            Log::error('Excel Import Error: ' . $e->getMessage());
            $this->toast('Error processing the Excel file. Please check the format and try again.', 'error');
            return back();
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
            
            // Set headers and make them bold
            $headers = ['name', 'jersey_number', 'top_size', 'short_size', 'has_pocket', 'remarks'];
            $col = 'A';
            foreach ($headers as $header) {
                $cell = $col . '1';
                $sheet->setCellValue($cell, $header);
                $sheet->getStyle($cell)->getFont()->setBold(true);
                $col++;
            }
            
            // Add some sample data
            $sampleData = [
                ['Player 1', '10', $defaultSize, $defaultSize, 'yes', 'Captain'],
                ['Player 2', '7', $defaultSize, $defaultSize, 'no', ''],
                ['Player 3', '9', $defaultSize, $defaultSize, '', ''],
            ];
            
            $row = 2;
            foreach ($sampleData as $rowData) {
                $col = 'A';
                foreach ($rowData as $value) {
                    $sheet->setCellValue($col . $row, $value);
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
            $notesSheet->setCellValue('C3', '2. Enter at least 10 rows of data.');
            $notesSheet->setCellValue('C4', '3. For has_pocket, use "yes" or "no" or leave blank for no.');
            $notesSheet->setCellValue('C5', '4. Use exact size names listed in the Size Guide column.');
            
            // Set the first sheet as active before saving
            $spreadsheet->setActiveSheetIndex(0);
            
            // Create Excel writer and save to template path
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $writer->save($templatePath);
        }
        
        // Check if template exists after generation attempt
        if (!file_exists($templatePath)) {
            $this->toast('Template not found or could not be generated.', 'error');
            return back();
        }
        
        return response()->download($templatePath);
    }
}
