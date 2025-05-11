<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Graduate extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'graduate_id';
    protected $guarded = ['graduate_id', 'deleted_at', 'created_at', 'updated_at'];

    public function educationalBackground(): HasMany
    {
        return $this->hasMany(EducationalBackground::class, 'graduate_id');
    }

    public function professionalExamination(): HasMany
    {
        return $this->hasMany(ProfessionalExamination::class, 'graduate_id');
    }

    public function reasonForCourse(): HasMany
    {
        return $this->hasMany(ReasonForCourse::class, 'graduate_id');
    }

    public function training(): HasMany
    {
        return $this->hasMany(Training::class, 'graduate_id');
    }

    public function reason(): HasMany
    {
        return $this->hasMany(Reason::class, 'graduate_id');
    }

    public function employmentStatus(): HasOne
    {
        return $this->hasOne(EmploymentStatus::class, 'graduate_id');
    }

    public function response(): HasMany
    {
        return $this->hasMany(Response::class, 'graduate_id');
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    //return the first letter of the first name in uppercase
    protected function fName(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => empty($value) ? null : ucfirst($value),
        );
    }

    //return the first letter of the last name in uppercase
    protected function lName(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) => empty($value) ? null : ucfirst($value),
        );
    }
}
