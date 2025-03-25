<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use App\Models\Sizes;

class StandardBulkImport extends BaseImport
{
    private $availableSizes;
    private $sizeQuantities = [];
    
    public function __construct($orderId, $token)
    {
        parent::__construct($orderId, $token);
        // Load all available sizes
        $this->availableSizes = Sizes::pluck('sizes_ID', 'name')->toArray();
    }
    
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if (!isset($row['size']) || !isset($row['quantity'])) {
                continue;
            }
            
            $size = trim(strtoupper($row['size']));
            $quantity = (int)$row['quantity'];
            
            if ($quantity <= 0 || empty($size)) {
                continue;
            }
            
            // Find size ID from name
            $sizeId = $this->findSizeId($size);
            
            if ($sizeId) {
                if (isset($this->sizeQuantities[$sizeId])) {
                    $this->sizeQuantities[$sizeId] += $quantity;
                } else {
                    $this->sizeQuantities[$sizeId] = $quantity;
                }
            }
        }
    }
    
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            '*.size' => 'required|string',
            '*.quantity' => 'required|integer|min:1',
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
     * Get the processed size quantities
     * 
     * @return array
     */
    public function getSizeQuantities()
    {
        return $this->sizeQuantities;
    }
    
    /**
     * Get total quantity
     * 
     * @return int
     */
    public function getTotalQuantity()
    {
        return array_sum($this->sizeQuantities);
    }
}
