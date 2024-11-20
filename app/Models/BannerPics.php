<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BannerPics extends Model
{
    use HasFactory;
    protected $table = 'banner_pic';
    protected $guarded = [];
    protected $primaryKey = 'bannerPic_id';



    public function banners()
    {
        return $this->belongsTo(Banners::class,'banner_id','banner_id');
    }
}
