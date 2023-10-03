<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Model
{
    protected $table = 'customers';

    protected $guard = 'customers';
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'password',
        'total_amount',
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'id');
    }
}
