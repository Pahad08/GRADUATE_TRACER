<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $primaryKey = 'response_id';
    protected $guarded = ['response_id', 'deleted_at', 'created_at', 'updated_at'];

    public function customQuestion()
    {
        return $this->belongsTo(CustomQuestion::class, 'custom_question_id');
    }
}
