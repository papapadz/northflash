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

    public function totalEmployees($param_date) {
        return $this::whereDate('payroll_date',$param_date)
            ->get();
    }

    public function totalPayments($param_date,$param_employee_id) {
        return $this::join('payroll','payroll.employee_id','=','payroll_generations.employee_id')
            ->join('payroll_items','payroll_items.id','=','payroll.payroll_item')
            ->whereDate('payroll_date',$param_date)
            ->where([
                    ['type',1],
                    ['payroll.employee_id',$param_employee_id]
                ])
            ->get();
    }

    public function employeeSalary($param_employee_id) {
        return $this::join('employments','employments.employee_id','=','payroll_generations.employee_id')
            ->join('salary','salary.id','=','employments.salary_id')
            ->where('employments.employee_id',$param_employee_id)
            ->orderBy('employments.created_at','desc')
            ->first();
    }
}
