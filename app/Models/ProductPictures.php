<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class ProductPictures extends Model
{
    use HasFactory;
    protected $table = 'product_pic';
    protected $guarded = [];
    protected $primaryKey = 'ProductPic_id';



    public function products()
    {
        return $this->belongsTo(Products::class,'product_id','product_id');
    }
}
