<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomQuestion extends Model
{
    protected $primaryKey = 'custom_question_id';
    protected $guarded = ['custom_question_id', 'deleted_at', 'created_at', 'updated_at'];

    public function questionOption()
    {
        return $this->hasMany(QuestionOption::class, 'custom_question_id');
    }

    public function response()
    {
        return $this->hasMany(Response::class, 'custom_question_id');
    }

    public function questionVisibility()
    {
        return $this->belongsTo(QuestionVisibility::class, 'question_id');
    }

    public function responsesWithTrashed()
    {
        return $this->belongsTo(QuestionVisibility::class, 'question_id')->withTrashed();
    }
}