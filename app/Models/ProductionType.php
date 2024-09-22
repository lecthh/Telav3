<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function productionCompany() {
        return $this->belongsTo(ProductionCompany::class, 'production_type', 'id');
    }
}
