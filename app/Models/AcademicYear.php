<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    protected $primaryKey = 'academic_year_id';
    protected $guarded = ['created_at', 'updated_at'];

    public function educationalBackground()
    {
        return $this->hasOne(EducationalBackground::class, 'academic_year_id');
    }

    protected function academicYear(): Attribute
    {
        return Attribute::get(
            fn() => ucfirst($this->start_year) . ' - ' . ucfirst($this->end_year)
        );
    }
}
