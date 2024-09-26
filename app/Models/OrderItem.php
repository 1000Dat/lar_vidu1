<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // Define the fillable fields
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    // Relationship with the Order model
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relationship with the Product model
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
