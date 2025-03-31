<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class GenerateExcelTemplates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'excel:generate-templates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Excel templates for bulk order imports';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Generate standard bulk template
        $this->generateStandardBulkTemplate();
        
        // Generate jersey bulk template
        $this->generateJerseyBulkTemplate();
        
        // Generate bulk customized template
        $this->generateBulkCustomizedTemplate();
        
        $this->info('Excel templates generated successfully!');
        
        return Command::SUCCESS;
    }
    
    /**
     * Generate standard bulk template
     */
    private function generateStandardBulkTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set headers
        $sheet->setCellValue('A1', 'Size');
        $sheet->setCellValue('B1', 'Quantity');
        
        // Add sample data
        $sheet->setCellValue('A2', 'S');
        $sheet->setCellValue('B2', 5);
        $sheet->setCellValue('A3', 'M');
        $sheet->setCellValue('B3', 5);
        $sheet->setCellValue('A4', 'L');
        $sheet->setCellValue('B4', 5);
        
        // Add instructions
        $sheet->setCellValue('D1', 'Instructions:');
        $sheet->setCellValue('D2', '1. Enter the size in the "Size" column (S, M, L, XL, etc.)');
        $sheet->setCellValue('D3', '2. Enter the quantity for each size in the "Quantity" column');
        $sheet->setCellValue('D4', '3. Total quantity must be at least 10 for bulk orders');
        
        // Style headers
        $sheet->getStyle('A1:B1')->getFont()->setBold(true);
        $sheet->getStyle('A1:B1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('9333EA');
        $sheet->getStyle('A1:B1')->getFont()->getColor()->setRGB('FFFFFF');
        
        // Style instructions
        $sheet->getStyle('D1')->getFont()->setBold(true);
        
        // Auto size columns
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        
        // Save file
        $writer = new Xlsx($spreadsheet);
        $writer->save(storage_path('app/excel_templates/standard_bulk_template.xlsx'));
    }
    
    /**
     * Generate jersey bulk template
     */
    private function generateJerseyBulkTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set headers
        $sheet->setCellValue('A1', 'Name');
        $sheet->setCellValue('B1', 'Jersey_Number');
        $sheet->setCellValue('C1', 'Top_Size');
        $sheet->setCellValue('D1', 'Short_Size');
        $sheet->setCellValue('E1', 'Has_Pocket');
        $sheet->setCellValue('F1', 'Remarks');
        
        // Add sample data
        $sheet->setCellValue('A2', 'John Doe');
        $sheet->setCellValue('B2', '10');
        $sheet->setCellValue('C2', 'M');
        $sheet->setCellValue('D2', 'L');
        $sheet->setCellValue('E2', 'Yes');
        $sheet->setCellValue('F2', 'Team Captain');
        
        // Add more sample rows
        $sheet->setCellValue('A3', 'Jane Smith');
        $sheet->setCellValue('B3', '7');
        $sheet->setCellValue('C3', 'S');
        $sheet->setCellValue('D3', 'M');
        $sheet->setCellValue('E3', 'No');
        $sheet->setCellValue('F3', '');
        
        // Add instructions
        $sheet->setCellValue('H1', 'Instructions:');
        $sheet->setCellValue('H2', '1. Fill in player details (all fields are required except Has_Pocket and Remarks)');
        $sheet->setCellValue('H3', '2. For Has_Pocket column, enter "Yes" or "No" (default is No)');
        $sheet->setCellValue('H4', '3. Add at least 10 rows for bulk orders');
        $sheet->setCellValue('H5', '4. Available sizes: XS, S, M, L, XL, XXL, etc.');
        
        // Style headers
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
        $sheet->getStyle('A1:F1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('9333EA');
        $sheet->getStyle('A1:F1')->getFont()->getColor()->setRGB('FFFFFF');
        
        // Style instructions
        $sheet->getStyle('H1')->getFont()->setBold(true);
        
        // Auto size columns
        for ($col = 'A'; $col <= 'H'; $col++) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Save file
        $writer = new Xlsx($spreadsheet);
        $writer->save(storage_path('app/excel_templates/jersey_bulk_template.xlsx'));
    }
    
    /**
     * Generate bulk customized template
     */
    private function generateBulkCustomizedTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set headers
        $sheet->setCellValue('A1', 'Name');
        $sheet->setCellValue('B1', 'Size');
        $sheet->setCellValue('C1', 'Remarks');
        
        // Add sample data
        $sheet->setCellValue('A2', 'John Doe');
        $sheet->setCellValue('B2', 'M');
        $sheet->setCellValue('C2', 'Red collar');
        
        $sheet->setCellValue('A3', 'Jane Smith');
        $sheet->setCellValue('B3', 'S');
        $sheet->setCellValue('C3', 'Green sleeves');
        
        // Add instructions
        $sheet->setCellValue('E1', 'Instructions:');
        $sheet->setCellValue('E2', '1. Enter the name in the "Name" column');
        $sheet->setCellValue('E3', '2. Enter the size in the "Size" column (S, M, L, XL, etc.)');
        $sheet->setCellValue('E4', '3. Enter optional remarks in the "Remarks" column');
        $sheet->setCellValue('E5', '4. You must add at least 10 rows for bulk orders');
        
        // Style headers
        $sheet->getStyle('A1:C1')->getFont()->setBold(true);
        $sheet->getStyle('A1:C1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('9333EA');
        $sheet->getStyle('A1:C1')->getFont()->getColor()->setRGB('FFFFFF');
        
        // Style instructions
        $sheet->getStyle('E1')->getFont()->setBold(true);
        
        // Auto size columns
        for ($col = 'A'; $col <= 'E'; $col++) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Save file
        $writer = new Xlsx($spreadsheet);
        $writer->save(storage_path('app/excel_templates/bulk_customized_template.xlsx'));
    }
}