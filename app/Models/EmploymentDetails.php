<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmploymentDetails extends Model
{
    protected $primaryKey = 'employment_details_id';
    protected $guarded = ['employment_status_id', 'deleted_at', 'created_at', 'updated_at'];

    public function EmploymentStatus(): BelongsTo
    {
        return $this->belongsTo(EmploymentStatus::class, 'employment_details_id');
    }

    public function jobDetails(): HasMany
    {
        return $this->hasMany(JobDetail::class, 'employment_details_id');
    }
}