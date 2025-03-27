<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    protected $primaryKey = 'suggestion_id';
    protected $guarded = ['suggestion_id', 'deleted_at', 'created_at', 'updated_at'];
}
