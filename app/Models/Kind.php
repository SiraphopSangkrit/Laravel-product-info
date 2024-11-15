<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kind extends Model
{
    use HasFactory;
    protected $table = 'kind';
    protected $guarded = [];
    protected $primaryKey = 'kind_id';
    public $incrementing = false;
    protected $keyType = 'string';
}
