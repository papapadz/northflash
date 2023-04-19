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

    public function employee() {
        return $this->hasOne(Employee::class,'employee_id','employee_id');
    }

    public function salary() {
        return $this->hasOne(Salary::class,'id','salary_id');
    }
}
