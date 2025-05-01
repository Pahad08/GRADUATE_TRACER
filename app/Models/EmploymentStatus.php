<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EmploymentStatus extends Model
{
    protected $primaryKey = 'employment_status_id';
    protected $table = 'employment_status';
    protected $guarded = ['employment_status_id', 'deleted_at', 'created_at', 'updated_at'];

    public function employmentDetails(): HasOne
    {
        return $this->hasOne(EmploymentDetails::class, 'employment_status_id');
    }
}