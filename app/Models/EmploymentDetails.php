<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmploymentDetails extends Model
{
    protected $primaryKey = 'employment_status_id';
    protected $guarded = ['employment_status_id', 'deleted_at', 'created_at', 'updated_at'];
}