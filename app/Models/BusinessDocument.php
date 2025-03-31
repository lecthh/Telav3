<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BusinessDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_company_id',
        'name',
        'path',
    ];

    /**
     * Get the production company that owns this document.
     */
    public function productionCompany()
    {
        return $this->belongsTo(ProductionCompany::class, 'production_company_id', 'id');
    }

    /**
     * Get the full URL for the document file.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return Storage::url($this->path);
    }

    /**
     * Delete the document file from storage and then delete the record.
     *
     * @return bool|null
     */
    public function deleteDocument()
    {
        if (Storage::exists($this->path)) {
            Storage::delete($this->path);
        }
        return $this->delete();
    }
}
