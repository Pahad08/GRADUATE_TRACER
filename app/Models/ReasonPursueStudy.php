<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReasonPursueStudy extends Model
{
    protected $primaryKey = 'training_id';
    protected $table = 'reason_pursue_studies';
    protected $guarded = ['training_id', 'deleted_at', 'created_at', 'updated_at'];
}
