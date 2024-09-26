<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleType extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_name'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role_type_id');
    }
}
