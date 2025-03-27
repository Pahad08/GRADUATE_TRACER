<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReasonForCourse extends Model
{
    protected $primaryKey = 'reason_id';
    protected $table = 'reason_for_course';
    protected $guarded = ['reason_id', 'deleted_at', 'created_at', 'updated_at'];
}
