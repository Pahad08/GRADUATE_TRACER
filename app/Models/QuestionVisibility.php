<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionVisibility extends Model
{
    use SoftDeletes;
    protected $primaryKey = 'question_id';
    protected $table = 'question_visibility';
    protected $guarded = ['question_id', 'deleted_at', 'created_at', 'updated_at'];

    public function question()
    {
        return $this->hasOne(CustomQuestion::class, 'question_id');
    }
}