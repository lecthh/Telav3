<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;

abstract class BaseImport implements ToCollection, WithHeadingRow, WithValidation
{
    protected $orderId;
    protected $token;
    
    public function __construct($orderId, $token)
    {
        $this->orderId = $orderId;
        $this->token = $token;
    }
    
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        // Implementation in child classes
    }
    
    /**
     * @return array
     */
    public function rules(): array
    {
        // Rules in child classes
        return [];
    }
    
    /**
     * @return array
     */
    public function customValidationMessages()
    {
        return [
            '*.required' => 'The :attribute field is required for each row.',
            '*.numeric' => 'The :attribute field must be a number.',
            '*.min' => 'The :attribute field must be at least :min.',
            '*.max' => 'The :attribute field must not exceed :max.',
        ];
    }
}
