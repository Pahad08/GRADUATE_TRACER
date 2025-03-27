<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Graduate extends Model
{
    protected $primaryKey = 'graduate_id';
    protected $guarded = ['graduate_id', 'deleted_at', 'created_at', 'updated_at'];

    public function EducationalBackground(): HasMany
    {
        return $this->hasMany(EducationalBackground::class, 'graduate_id');
    }

    public function ProfessionalExamination(): HasMany
    {
        return $this->hasMany(ProfessionalExamination::class, 'graduate_id');
    }

    public function ReasonForCourse(): HasMany
    {
        return $this->hasMany(ReasonForCourse::class, 'graduate_id');
    }

    public function Training(): HasMany
    {
        return $this->hasMany(Training::class, 'graduate_id');
    }

    public function ReasonPursueStudies(): HasMany
    {
        return $this->hasMany(ReasonPursueStudy::class, 'graduate_id');
    }

    public function EmploymentStatus(): HasOne
    {
        return $this->hasOne(EmploymentStatus::class, 'graduate_id');
    }
}
