<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    protected $primaryKey = 'question_option_id';
    protected $guarded = ['question_option_id', 'deleted_at', 'created_at', 'updated_at'];
}
