<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table="products";

    protected $fillable =[
        'name','description','status'
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Categories::class, 'category_product', 'product_id', 'category_id');
    }

    // public function getStatusDisplayAttribute()
    // {
    //     return $this->status === 'active' ? 'Active' : 'Inactive';
    // }
}

