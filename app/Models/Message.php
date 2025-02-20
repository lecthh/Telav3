<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    public $table = 'messages';
    protected $fillable = ['from_id', 'to_id', 'body', 'attachments', 'seen'];

    protected $casts = [
        'attachments' => 'array',
    ];

    public function fromUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from_id');
    }

    public function toUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to_id');
    }

    public function getTimeAttribute(): string
    {
        return date(
            "d M Y, H:i:s",
            strtotime($this->attributes['created_at'])
        );
    }
}
