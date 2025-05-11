<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HEI extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'hei_id';
    protected $table = 'hei';
    protected $guarded = ['hei_id', 'deleted_at', 'created_at', 'updated_at'];
}