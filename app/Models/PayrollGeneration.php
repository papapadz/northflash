<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PayrollGeneration extends Model
{
    protected $fillable = [
        'employee_id',
        'payroll_item',
        'amount',
        //'num_days',
        //'payroll_date',
        //'generated_by'
        'updated_by',
        'qty',
        'payroll_master_id',
        'total'
    ];

    /** new */
    public function payrollItem() {
        return $this->hasOne(PayrollItem::class,'id','payroll_item');
    }

    public function payrollMaster() {
        return $this->belongsTo(PayrollGenerationMaster::class,'payroll_master_id','id');
    }
    
    /** old */
    public function monthlySalaryAmount($param_date) {
        return $this::join('payroll_items','payroll_items.id','=','payroll_item')
            ->where('payroll_items.type',1)
            ->whereDate('payroll_date',Carbon::parse($param_date)->toDateString())
            ->sum('payroll_generations.amount');
    }

    public function monthlyDeductionAmount($param_date) {
        return $this::join('payroll_items','payroll_items.id','=','payroll_item')
            ->where('payroll_items.type',2)
            ->whereDate('payroll_date',Carbon::parse($param_date)->toDateString())
            ->sum('payroll_generations.amount');
    }

    public function getPayslipDetails($param_date,$param_employee_id) {
        return $this::select('payroll_item','item','payroll_generations.amount','type','payroll_date')->join('payroll_items','payroll_items.id','=','payroll_item')
            ->where('employee_id',$param_employee_id)
            ->whereDate('payroll_date',Carbon::parse($param_date)->toDateString());
    }


    public function totalEmployees($param_date) {
        
        return $this::whereDate('payroll_date',$param_date)
            ->get();
    }

    public function employeePayroll($param_date,$param_employee_id,$param_type,$param_period) {
        
        return $this::join('payroll','payroll.employee_id','=','payroll_generations.employee_id')
            ->join('payroll_items','payroll_items.id','=','payroll.payroll_item')
            ->whereDate('payroll_date',$param_date)
            ->where([
                    ['type',$param_type],
                    ['deduction_period',$param_period],
                    ['payroll.employee_id',$param_employee_id],
                ])
            ->orWhere('deduction_period',0)
            ->get();
    }

    public function monthlyPayroll($param_date,$param_employee_id) {

        $start_date = Carbon::parse($param_date)->startOfMonth()->toDateString();
        $end_date = Carbon::parse($param_date)->endOfMonth()->toDateString();

        return $this::join('payroll','payroll.employee_id','=','payroll_generations.employee_id')
            ->join('payroll_items','payroll_items.id','=','payroll.payroll_item')
            ->whereIn('payroll_date',[$start_date,$end_date])
            ->where([
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

    public function employeeInfo() {
        return $this::hasOne('App\Models\Employee','employee_id','employee_id');
    }
}
