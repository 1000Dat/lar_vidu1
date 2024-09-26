<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Define the fillable fields
    protected $fillable = ['user_id', 'shipping_address', 'payment_method', 'status', 'total_price'];

    // Relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with the OrderItem model
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
