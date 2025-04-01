<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use App\Models\Sizes;

class JerseyBulkImport extends BaseImport
{
    private $availableSizes;
    private $jerseyDetails = [];
    
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
        \Illuminate\Support\Facades\Log::info("Starting import with " . count($rows) . " rows");
        
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
            
            // Check for missing required fields and log it
            $missingFields = [];
            if (!isset($row['name'])) $missingFields[] = 'name';
            if (!isset($row['jersey_number'])) $missingFields[] = 'jersey_number';
            if (!isset($row['top_size'])) $missingFields[] = 'top_size';
            if (!isset($row['short_size'])) $missingFields[] = 'short_size';
            
            if (!empty($missingFields)) {
                \Illuminate\Support\Facades\Log::warning("Row {$rowNum} missing fields: " . implode(', ', $missingFields) . ". Available keys: " . implode(', ', array_keys($row->toArray())));
                continue;
            }
            
            try {
                $name = trim((string)$row['name']);
                
                // Convert jersey number to string, handling both numeric and string inputs
                $jerseyNumber = is_numeric($row['jersey_number']) ? (string)$row['jersey_number'] : trim((string)$row['jersey_number']);
                
                $topSize = trim(strtoupper((string)$row['top_size']));
                $shortSize = trim(strtoupper((string)$row['short_size']));
                $remarks = isset($row['remarks']) ? trim((string)$row['remarks']) : '';
                
                // Handle various formats for has_pocket
                $hasPocketValue = isset($row['has_pocket']) ? $row['has_pocket'] : '';
                $hasPocket = false;
                
                if (is_bool($hasPocketValue)) {
                    $hasPocket = $hasPocketValue;
                } elseif (is_string($hasPocketValue) || is_numeric($hasPocketValue)) {
                    $hasPocketStr = strtolower((string)$hasPocketValue);
                    $hasPocket = $hasPocketStr === 'yes' || 
                                 $hasPocketStr === 'true' || 
                                 $hasPocketStr === '1' || 
                                 $hasPocketStr === 'y' ||
                                 $hasPocketValue === 1 ||
                                 $hasPocketValue === true;
                }
                
                // Skip rows with empty required fields
                if (empty($name) || empty($jerseyNumber) || empty($topSize) || empty($shortSize)) {
                    \Illuminate\Support\Facades\Log::info("Row {$rowNum} has empty values: name='{$name}', jersey='{$jerseyNumber}', top='{$topSize}', short='{$shortSize}'");
                    continue;
                }
                
                // Find size IDs
                $topSizeId = $this->findSizeId($topSize);
                $shortSizeId = $this->findSizeId($shortSize);
                
                // Debug logging to help troubleshoot size mapping issues
                if (!$topSizeId) {
                    \Illuminate\Support\Facades\Log::warning("Row {$rowNum}: Could not find top size ID for: '{$topSize}'");
                }
                
                if (!$shortSizeId) {
                    \Illuminate\Support\Facades\Log::warning("Row {$rowNum}: Could not find short size ID for: '{$shortSize}'");
                }
                
                if ($topSizeId && $shortSizeId) {
                    $this->jerseyDetails[] = [
                        'name' => $name,
                        'jerseyNo' => $jerseyNumber,
                        'topSize' => $topSizeId,
                        'shortSize' => $shortSizeId,
                        'hasPocket' => $hasPocket,
                        'remarks' => $remarks
                    ];
                    \Illuminate\Support\Facades\Log::info("Row {$rowNum}: Successfully added jersey for '{$name}'");
                } else {
                    \Illuminate\Support\Facades\Log::warning("Row {$rowNum}: Could not add jersey for '{$name}' due to invalid sizes");
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Error processing row {$rowNum}: " . $e->getMessage() . "\nRow data: " . json_encode($row->toArray()));
            }
        }
        
        \Illuminate\Support\Facades\Log::info("Import completed. Added " . count($this->jerseyDetails) . " jersey details out of " . count($rows) . " rows");
    }
    
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            '*.name' => 'required|string',
            '*.jersey_number' => 'required',  // Remove string validation to accept numeric values
            '*.top_size' => 'required|string',
            '*.short_size' => 'required|string',
            '*.remarks' => 'nullable|string',
            '*.has_pocket' => 'nullable'
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
        // Standardize the size name (uppercase and trim)
        $standardizedSize = trim(strtoupper($sizeName));
        
        // Handle numeric size IDs directly
        if (is_numeric($sizeName) && in_array($sizeName, $this->availableSizes)) {
            return $sizeName;
        }
        
        // Exact match
        if (isset($this->availableSizes[$sizeName])) {
            return $this->availableSizes[$sizeName];
        }
        
        // Try case-insensitive search
        foreach ($this->availableSizes as $name => $id) {
            if (strtoupper($name) === $standardizedSize) {
                return $id;
            }
        }
        
        // Try common size mappings
        $sizeMappings = [
            'EXTRA SMALL' => ['XS', 'XXS'],
            'SMALL' => ['S'],
            'MEDIUM' => ['M'],
            'LARGE' => ['L'],
            'EXTRA LARGE' => ['XL', 'XXL'],
            'XXS' => ['EXTRA EXTRA SMALL'],
            'XS' => ['EXTRA SMALL'],
            'S' => ['SMALL'],
            'M' => ['MEDIUM', 'MED'],
            'L' => ['LARGE', 'LG'],
            'XL' => ['EXTRA LARGE', 'X LARGE'],
            'XXL' => ['EXTRA EXTRA LARGE', 'XX LARGE', 'DOUBLE XL']
        ];
        
        // Check if our size matches any of the mappings
        foreach ($sizeMappings as $originalSize => $alternativeSizes) {
            // If the standardized size matches an alternative
            if (in_array($standardizedSize, $alternativeSizes)) {
                // Look for the original size in our available sizes
                foreach ($this->availableSizes as $name => $id) {
                    if (strtoupper($name) === strtoupper($originalSize)) {
                        return $id;
                    }
                }
            }
        }
        
        // Debug info
        \Illuminate\Support\Facades\Log::info("Available sizes: " . json_encode($this->availableSizes));
        \Illuminate\Support\Facades\Log::info("Trying to find match for: '{$sizeName}' (standardized: '{$standardizedSize}')");
        
        return null;
    }
    
    /**
     * Get the jersey details
     * 
     * @return array
     */
    public function getJerseyDetails()
    {
        return $this->jerseyDetails;
    }
    
    /**
     * Get total quantity
     * 
     * @return int
     */
    public function getTotalQuantity()
    {
        return count($this->jerseyDetails);
    }
}
