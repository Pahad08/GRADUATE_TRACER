<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    protected $primaryKey = 'university_id';
    protected $table = 'universities';  
    protected $guarded = ['university_id', 'deleted_at', 'created_at', 'updated_at'];
}