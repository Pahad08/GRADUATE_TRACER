<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Province extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'province_id';
    protected $guarded = ['province_id', 'deleted_at', 'created_at', 'updated_at'];
}
