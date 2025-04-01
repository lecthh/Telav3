<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use App\Models\Sizes;

class BulkCustomizedImport extends BaseImport
{
    private $availableSizes;
    private $customizationDetails = [];
    
    public function __construct($orderId, $token)
    {
        parent::__construct($orderId, $token);
        $this->availableSizes = Sizes::pluck('sizes_ID', 'name')->toArray();
    }
    
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        \Illuminate\Support\Facades\Log::info("Starting bulk customized import with " . count($rows) . " rows");
        
        // Debug the first row to see headers
        if (count($rows) > 0) {
            $firstRow = $rows->first();
            \Illuminate\Support\Facades\Log::info("First row keys: " . json_encode(array_keys($firstRow->toArray())));
            \Illuminate\Support\Facades\Log::info("First row data: " . json_encode($firstRow->toArray()));
        }
        
        $rowNum = 0;
        foreach ($rows as $row) {
            $rowNum++;
            
            // Skip empty rows
            if (empty($row) || (count(array_filter($row->toArray())) == 0)) {
                \Illuminate\Support\Facades\Log::info("Skipping empty row {$rowNum}");
                continue;
            }
            
            try {
                // Detect required fields based on available keys
                $descriptionField = null;
                $sizeField = null;
                $quantityField = null;
                $remarksField = null;
                
                $rowKeys = array_keys($row->toArray());
                
                // Look for name/description field
                foreach (['description', 'desc', 'name', 'item', 'item_name'] as $possibleKey) {
                    if (isset($row[$possibleKey]) && !empty($row[$possibleKey])) {
                        $descriptionField = $possibleKey;
                        break;
                    }
                }
                
                // Look for size field
                foreach (['size', 'item_size', 'apparel_size'] as $possibleKey) {
                    if (isset($row[$possibleKey]) && !empty($row[$possibleKey])) {
                        $sizeField = $possibleKey;
                        break;
                    }
                }
                
                // Look for quantity field
                foreach (['quantity', 'qty', 'count', 'amount'] as $possibleKey) {
                    if (isset($row[$possibleKey]) && !empty($row[$possibleKey])) {
                        $quantityField = $possibleKey;
                        break;
                    }
                }
                
                // Look for remarks field
                foreach (['remarks', 'notes', 'comment', 'comments', 'additional'] as $possibleKey) {
                    if (isset($row[$possibleKey])) { // Can be empty
                        $remarksField = $possibleKey;
                        break;
                    }
                }
                
                // If required fields not found, check if this is a fixed column CSV/Excel 
                if (!$descriptionField && isset($row[0]) && !empty($row[0])) {
                    $descriptionField = 0;
                    if (isset($row[1]) && !empty($row[1])) $sizeField = 1;
                    if (isset($row[2]) && !empty($row[2])) $quantityField = 2;
                    if (isset($row[3])) $remarksField = 3;
                }
                
                // Log fields detected
                \Illuminate\Support\Facades\Log::info("Row {$rowNum}: Fields detected - desc:{$descriptionField}, size:{$sizeField}, qty:{$quantityField}, remarks:{$remarksField}");
                
                // Check if required fields are missing
                if (!$descriptionField || !$sizeField) {
                    \Illuminate\Support\Facades\Log::warning("Row {$rowNum} missing required fields. Available keys: " . implode(', ', $rowKeys));
                    continue;
                }
                
                $description = trim($row[$descriptionField]);
                $size = trim(strtoupper($row[$sizeField]));
                $quantity = $quantityField ? intval($row[$quantityField]) : 1;
                $remarks = $remarksField ? trim($row[$remarksField]) : '';
                
                // Skip rows with empty required fields
                if (empty($description) || empty($size)) {
                    \Illuminate\Support\Facades\Log::info("Row {$rowNum} has empty values: description='{$description}', size='{$size}'");
                    continue;
                }
                
                // Find size ID
                $sizeId = $this->findSizeId($size);
                
                if (!$sizeId) {
                    \Illuminate\Support\Facades\Log::warning("Row {$rowNum}: Could not find size ID for: '{$size}'");
                    // Try to use default size as fallback
                    $defaultSizeKey = key($this->availableSizes);
                    if ($defaultSizeKey) {
                        $sizeId = $this->availableSizes[$defaultSizeKey];
                        \Illuminate\Support\Facades\Log::info("Row {$rowNum}: Using default size '{$defaultSizeKey}' with ID {$sizeId} instead");
                    }
                }
                
                if ($sizeId) {
                    $this->customizationDetails[] = [
                        'name' => $description,  // Change key from 'description' to 'name' to match view expectations
                        'size' => $sizeId,
                        'quantity' => $quantity,
                        'remarks' => $remarks
                    ];
                    \Illuminate\Support\Facades\Log::info("Row {$rowNum}: Successfully added customization for '{$description}'");
                } else {
                    \Illuminate\Support\Facades\Log::warning("Row {$rowNum}: Could not add customization for '{$description}' due to invalid size");
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Error processing row {$rowNum}: " . $e->getMessage() . "\nRow data: " . json_encode($row->toArray()));
            }
        }
        
        \Illuminate\Support\Facades\Log::info("Bulk customized import completed. Added " . count($this->customizationDetails) . " customization details out of " . count($rows) . " rows");
    }
    
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            '*.name' => 'required|string',
            '*.size' => 'required|string',
            '*.remarks' => 'nullable|string'
        ];
    }
    
    /**
     * Find size ID from size name
     * 
     * @param string $sizeName
     * @return int|null
     */
    private function findSizeId($sizeName)
    {
        // Exact match
        if (isset($this->availableSizes[$sizeName])) {
            return $this->availableSizes[$sizeName];
        }
        
        // Try case-insensitive search
        foreach ($this->availableSizes as $name => $id) {
            if (strtoupper($name) === strtoupper($sizeName)) {
                return $id;
            }
        }
        
        return null;
    }
    
    /**
     * Get the customization details
     * 
     * @return array
     */
    public function getCustomizationDetails()
    {
        return $this->customizationDetails;
    }
    
    /**
     * Get total quantity
     * 
     * @return int
     */
    public function getTotalQuantity()
    {
        return count($this->customizationDetails);
    }
}
