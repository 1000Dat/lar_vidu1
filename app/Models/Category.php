<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
      // Specify the attributes that are mass assignable
      protected $fillable = [
        'name',
    ];

    // If you have timestamps, you might need this
    public $timestamps = true;
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
}