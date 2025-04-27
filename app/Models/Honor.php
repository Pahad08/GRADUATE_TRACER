<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Honor extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'honor_id';
    protected $guarded = ['honor_id', 'created_at', 'updated_at'];
}