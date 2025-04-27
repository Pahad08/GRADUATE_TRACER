<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    protected $primaryKey = 'reason_id';
    protected $guarded = ['reason_id', 'deleted_at', 'created_at', 'updated_at'];
}