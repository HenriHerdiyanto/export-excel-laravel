<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";
    protected $fillable = [
        "name",
        "description",
        "price",
        "image",
        "categori_id", // ubah dari 'categori_id' ke 'category_id'
        "status",
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categori_id');
    }
}
