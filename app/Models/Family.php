<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    protected $table = 'family_information';
    protected $fillable = [
        'employee_id', 'relationship', 'name', 'phone', 'occupation'
    ];
}
