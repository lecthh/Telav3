<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ReportImage extends Model
{
    protected $fillable = [
        'report_id',
        'path',
        'filename',
        'mime_type',
        'size'
    ];

    /**
     * Get the report that owns this image.
     */
    public function report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

    /**
     * Get the full URL of the image.
     */
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }
}
