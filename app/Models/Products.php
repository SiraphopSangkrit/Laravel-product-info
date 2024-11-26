<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Brands;
use App\Models\Group;
use App\Models\Kind;
use App\Models\ProductType;


class Products extends Model

{
    use HasFactory;
    protected $table = 'products';
    protected $guarded = [];

    protected $primaryKey = 'product_id';
    public $incrementing = false;
    protected $keyType = 'string';

    public function brands()
    {
        return $this->belongsTo(Brands::class,'brand_id','brand_id');
    }

    public function kinds()
    {
        return $this->belongsTo(Kind::class,'kind_id','kind_id');
    }
    public function groups()
    {
        return $this->belongsTo(Group::class,'group_id','group_id');
    }
    public function types()
    {
        return $this->belongsTo(ProductType::class,'producttype_id','producttype_id');
    }

    public function productPics(){
        return $this->hasMany(ProductPictures::class,'product_id');
    }

}
