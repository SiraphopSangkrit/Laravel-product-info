<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Products;

class Brands extends Model
{
    use HasFactory;
    protected $table = 'brand';
    protected $guarded = [];

    protected $primaryKey = 'brand_id';
    public $incrementing = false;
    protected $keyType = 'string';

    public function products()
    {
        return $this->hasMany(Products::class);
    }
}
