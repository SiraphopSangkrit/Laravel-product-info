<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Banners extends Model
{
    use HasFactory;
    protected $table = 'banner';
    protected $guarded = [];
    protected $primaryKey = 'banner_id';

    public function bannerPics(){
        return $this->hasMany(bannerPics::class,'banner_id');
    }
}
