<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employment extends Model
{
    protected $fillable = [
        'employee_id',
        'salary_id',
        'status',
        'date_hired',
        'date_expired'
    ];
}
