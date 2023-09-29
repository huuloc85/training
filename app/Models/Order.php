<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders'; // Tên bảng trong CSDL

    protected $fillable = ['customer_id', 'total', 'date_at', 'note']; // Các trường cho phép fillable

    // Các phương thức hoặc liên kết đến khách hàng (nếu có)
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_details', 'order_id', 'product_id');
    }

    public function scopeSearch($query)
    {
        if ($key = request()->key) {
            $query->join('customers', 'orders.customer_id', '=', 'customers.id')
                ->where('customers.name', 'like', '%' . $key . '%')
                ->orwhere('customers.email', 'like', '%' . $key . '%')
                ->orwhere('customers.phone', 'like', '%' . $key . '%')
                ->orwhere('customers.address', 'like', '%' . $key . '%');
        }
        return $query;
    }
}
