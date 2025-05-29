<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EducationalBackground extends Model
{
    use hasFactory, SoftDeletes;

    protected $primaryKey = 'educational_background_id';
    protected $guarded = ['educational_background_id', 'deleted_at', 'created_at', 'updated_at'];

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }

    public function graduates(): BelongsTo
    {
        return $this->belongsTo(Graduate::class, 'graduate_id');
    }

    public function honor()
    {
        return $this->hasMany(Honor::class, 'educational_background_id');
    }
}
