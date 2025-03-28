<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EmploymentStatus extends Model
{
    protected $primaryKey = 'employment_status_id';
    protected $table = 'employment_status';
    protected $guarded = ['employment_status_id', 'deleted_at', 'created_at', 'updated_at'];

    public function EmploymentReason(): HasMany
    {
        return $this->hasMany(EmploymentReason::class, 'employment_status_id');
    }

    public function EmploymentDetails(): BelongsTo
    {
        return $this->belongsTo(EmploymentDetails::class, 'employment_status_id');
    }
}
