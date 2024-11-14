<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Group extends Model
{
    use HasFactory;
    protected $table = 'group';
    protected $guarded = [];

    protected $primaryKey = 'group_id';
    public $incrementing = false;
    protected $keyType = 'string';
}
