<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Report extends Model
{
    protected $fillable = [
        'reporter_id',
        'reporter_type',
        'reported_id',
        'reported_type',
        'reason',
        'description',
        'status',
        'order_id'
    ];

    /**
     * Get the model that reported the issue.
     */
    public function reporter()
    {
        return $this->morphTo();
    }

    /**
     * Get the model that is being reported.
     */
    public function reported()
    {
        return $this->morphTo();
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    public function images()
    {
        return $this->hasMany(ReportImage::class);
    }

    public function stripHtmlReason()
    {
        $stripped = strip_tags($this->reason);
        $items = preg_split('/(?=[A-Z])/', $stripped, -1, PREG_SPLIT_NO_EMPTY);
        $formatted = Str::limit(implode(', ', $items), 100, '...');
        return $formatted;
    }
}
