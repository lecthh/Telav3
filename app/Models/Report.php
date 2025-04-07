<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'reporter_id',
        'reporter_type',
        'reported_id',
        'reported_type',
        'reason',
        'description',
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
}
