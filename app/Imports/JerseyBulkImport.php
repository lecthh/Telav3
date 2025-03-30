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
        foreach ($rows as $row) {
            if (!isset($row['name']) || !isset($row['jersey_number']) || 
                !isset($row['top_size']) || !isset($row['short_size'])) {
                continue;
            }
            
            $name = trim($row['name']);
            // Convert jersey number to string, handling both numeric and string inputs
            $jerseyNumber = is_numeric($row['jersey_number']) ? (string)$row['jersey_number'] : trim($row['jersey_number']);
            $topSize = trim(strtoupper($row['top_size']));
            $shortSize = trim(strtoupper($row['short_size']));
            $remarks = isset($row['remarks']) ? trim($row['remarks']) : '';
            $hasPocket = isset($row['has_pocket']) && 
                         (strtolower($row['has_pocket']) === 'yes' || 
                          strtolower($row['has_pocket']) === 'true' || 
                          $row['has_pocket'] === '1' ||
                          $row['has_pocket'] === 1);
            
            if (empty($name) || empty($jerseyNumber) || empty($topSize) || empty($shortSize)) {
                continue;
            }
            
            // Find size IDs
            $topSizeId = $this->findSizeId($topSize);
            $shortSizeId = $this->findSizeId($shortSize);
            
            // Debug logging to help troubleshoot size mapping issues
            if (!$topSizeId) {
                \Illuminate\Support\Facades\Log::warning("Could not find top size ID for: '{$topSize}'");
            }
            
            if (!$shortSizeId) {
                \Illuminate\Support\Facades\Log::warning("Could not find short size ID for: '{$shortSize}'");
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
            }
        }
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
