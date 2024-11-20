<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class NewsPics extends Model
{
    use HasFactory;
    protected $table = 'news_pic';
    protected $guarded = [];
    protected $primaryKey = 'newsPic_id';



    public function news()
    {
        return $this->belongsTo(Banners::class,'news_id','news_id');
    }
}
