<?php

namespace App\Models;

use Database\Factories\DegreesFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return DegreesFactory::new();
    }

    protected $primaryKey = 'degree_id';
    protected $guarded = ['degree_id', 'deleted_at', 'created_at', 'updated_at'];
}
