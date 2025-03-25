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
        foreach ($rows as $row) {
            if (!isset($row['name']) || !isset($row['size'])) {
                continue;
            }
            
            $name = trim($row['name']);
            $size = trim(strtoupper($row['size']));
            $remarks = isset($row['remarks']) ? trim($row['remarks']) : '';
            
            if (empty($name) || empty($size)) {
                continue;
            }
            
            // Find size ID
            $sizeId = $this->findSizeId($size);
            
            if ($sizeId) {
                $this->customizationDetails[] = [
                    'name' => $name,
                    'size' => $sizeId,
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
