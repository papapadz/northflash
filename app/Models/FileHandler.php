<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileHandler extends Model
{
    protected $fillable = [
        'file_type', 'url'
    ];
}
