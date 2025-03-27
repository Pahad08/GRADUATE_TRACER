<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    protected $primaryKey = 'training_id';
    protected $guarded = ['training_id', 'deleted_at', 'created_at', 'updated_at'];
}