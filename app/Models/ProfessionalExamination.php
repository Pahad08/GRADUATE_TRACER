<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessionalExamination extends Model
{
    protected $primaryKey = 'professional_examination_id';
    protected $guarded = ['professional_examination_id', 'deleted_at', 'created_at', 'updated_at'];
}
