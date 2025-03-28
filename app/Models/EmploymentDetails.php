<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class EmploymentDetails extends Model
{
    protected $primaryKey = 'employment_status_id';
    protected $guarded = ['employment_status_id', 'deleted_at', 'created_at', 'updated_at'];

    public function EmploymentStatus(): HasOne
    {
        return $this->hasOne(EmploymentStatus::class, 'employment_status_id');
    }
}
