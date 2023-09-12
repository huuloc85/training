<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "products";

    protected $fillable = ['user_added', 'user_updated', 'proName', 'proSlug', 'proPrice', 'proDetail', 'proImage', 'category_id', 'proQuantity'];

    public function userAdded()
    {
        return $this->belongsTo(User::class, 'user_added', 'id');
    }

    public function userUpdated()
    {
        return $this->belongsTo(User::class, 'user_updated', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_details', 'product_id', 'order_id');
    }

    public function orderdetails()
    {
        return $this->hasMany(OrderDetail::class, 'product_id', 'id');
    }
}
