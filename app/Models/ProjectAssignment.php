<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectAssignment extends Model
{
    protected $fillable = ['employee_id','project_id'];

    public function employee() {
        return $this->hasOne(Employee::class,'employee_id','employee_id');
    }
}
