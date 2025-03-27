<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    protected $primaryKey = 'degree_id';
    protected $guarded = ['degree_id', 'deleted_at', 'created_at', 'updated_at'];
}