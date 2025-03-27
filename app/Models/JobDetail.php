<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobDetail extends Model
{
    protected $primaryKey = 'job_detail_id';
    protected $guarded = ['job_detail_id', 'deleted_at', 'created_at', 'updated_at'];
}