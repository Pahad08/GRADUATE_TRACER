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

    public function degree(): BelongsTo
    {
        return $this->belongsTo(Degree::class, 'degree_id');
    }

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class, 'university_id');
    }

    public function honor()
    {
        return $this->hasMany(Honor::class, 'educational_background_id');
    }
}