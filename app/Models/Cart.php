<?php

namespace App\Models;
use App\Models\Cart; // Đảm bảo rằng bạn có lớp Cart trong Models

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
//     public function items()
// {
//     return $this->hasMany(CartItem::class, 'cart_id');
// }
}
