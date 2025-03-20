<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements MustVerifyEmail
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
        'passwordToken',
        'avatar',

    ];

    public function roleType()
    {
        return $this->hasOne(RoleType::class, 'id', 'role_type_id');
    }
    public function addressInformation()
    {
        return $this->hasOne(AddressInformation::class, 'user_id', 'user_id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'user_id');
    }
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id', 'user_id');
    }

    public function messagesSent(): HasMany
    {
        return $this->hasMany(Message::class, 'from_id', 'user_id');
    }

    public function messagesReceived(): HasMany
    {
        return $this->hasMany(Message::class, 'to_id', 'user_id');
    }

    public function scopeCustomer($query)
    {
        return $query->where('role_type_id', 1);
    }
}
