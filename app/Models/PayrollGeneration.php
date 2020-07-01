<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollGeneration extends Model
{
    protected $fillable = [
        'employee_id',
        'regular_days',
        'ot',
        'ut',
        'payroll_date',
        'generated_by'
    ];

    protected $dates = ['payroll_date'];

    protected $casts = [
        'ot' => 'integer',
        'ut' => 'integer'
    ];

    public function totalEmployees($param_date) {
        return $this::whereDate('payroll_date',$param_date)
            ->get();
    }

    public function employeePayroll($param_date,$param_employee_id,$param_type) {
        return $this::join('payroll','payroll.employee_id','=','payroll_generations.employee_id')
            ->join('payroll_items','payroll_items.id','=','payroll.payroll_item')
            ->whereDate('payroll_date',$param_date)
            ->where([
                    ['type',$param_type],
                    ['payroll.employee_id',$param_employee_id]
                ])
            ->get();
    }

    public function employeeSalary($param_employee_id,$param_date) {
        return $this::join('employments','employments.employee_id','=','payroll_generations.employee_id')
            ->join('salary','salary.employment_id','=','employments.id')
            ->where('employments.employee_id',$param_employee_id)
            ->whereDate('salary.date_effective','<=',$param_date)
            ->orderBy('salary.date_effective','desc')
            ->orderBy('salary.created_at','desc')
            ->first();
    }

    public function employee() {
        return $this->hasOne('App\Models\Employee','employee_id','employee_id');
    }
}
