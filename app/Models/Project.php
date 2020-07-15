<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'project_name',
        'location',
        'project_type',
        'start_date',
        'end_date',
        'contract_by',
        'amount'
    ];

    protected $dates = [
        'start_date',
        'end_date'
    ];

    public function employees() {
        return $this->hasMany('App\Models\ProjectAssignment','project_id','id')
            ->join('employees','employees.employee_id','=','project_assignments.employee_id');
    }
}
