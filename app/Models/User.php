<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'password',
        'role_type_id',
        'passwordToken'
    ];

    public function roleType()
    {
        return $this->hasOne(RoleType::class, 'id', 'role_type_id');
    }
    public function addressInformation()
    {
        return $this->hasOne(AddressInformation::class, 'user_id', 'user_id');
    }
    public function orders(){
        return $this->hasMany(Order::class, 'user_id', 'user_id');
    }
}
