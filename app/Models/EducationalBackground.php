<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EducationalBackground extends Model
{
    protected $primaryKey = 'education_background_id';
    protected $guarded = ['education_background_id', 'deleted_at', 'created_at', 'updated_at'];
}
