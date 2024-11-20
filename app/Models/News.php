<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
{
    use HasFactory;
    protected $table = 'news';
    protected $guarded = [];
    protected $primaryKey = 'news_id';

    public function newsPics(){
        return $this->hasMany(newsPics::class,'news_id');
    }
}
