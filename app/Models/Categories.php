<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    protected $table="categories";
    protected $fillable=[
        'name','parent_category'
    ];



    public function products()
    {
    return $this->belongsToMany(Product::class, 'category_product', 'category_id', 'product_id');
    }
}
