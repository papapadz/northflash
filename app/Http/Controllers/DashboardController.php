<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PayrollGeneration;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Project;

class DashboardController extends Controller
{
    public function index() {

        $now = Carbon::now();

        $annualreport = array(0,0,0,0,0,0,0,0,0,0,0,0);

        $payrollgeneration = PayrollGeneration::select('payroll_date')
            ->whereBetween('payroll_date',[
                $now->startOfYear()->toDateString(),$now->endOfYear()->toDateString()
            ])
            ->groupBy('payroll_date')
            ->orderBy('payroll_date','desc')
            ->get();
        
            $grandtotal = $grandtotald = 0;
        foreach($payrollgeneration as $k => $generation) {
            $total = $totald = 0;
                  foreach($generation->totalEmployees(Carbon::parse($generation->payroll_date)->toDateString()) as $emp) {
                    $empbenefits = $empdeductions = 0;
                    foreach($emp->employeePayroll(Carbon::parse($generation->payroll_date)->toDateString(),$emp->employee_id,1) as $payroll) {
                      
                      if($payroll->payroll_item == 7 && (Carbon::parse($generation->payroll_date)->month == 5 || Carbon::parse($generation->payroll_date)->month == 11)) {
                        $empbenefits = $empbenefits + ($emp->employeeSalary($emp->employee_id)->amount/2);
                      } else if($payroll->payroll_item != 7) {
                          if($payroll->payroll_item == 5)
                            $empbenefits = $empbenefits + (findPayroll($payroll->payroll_item,$emp->employeeSalary($emp->employee_id)->amount,$payroll->amount) * $emp->ot);
                          else
                            $empbenefits = $empbenefits + findPayroll($payroll->payroll_item,$emp->employeeSalary($emp->employee_id)->amount,$payroll->amount);
                        }
                    }
                    foreach($emp->employeePayroll(Carbon::parse($generation->payroll_date)->toDateString(),$emp->employee_id,2) as $payrolld) {
                      if($payroll->payroll_item == 6)
                        $empdeductions = $empdeductions + (findPayroll($payrolld->payroll_item,$emp->employeeSalary($emp->employee_id)->amount,$payrolld->amount) * $emp->ut);
                      else
                        $empdeductions = $empdeductions + findPayroll($payrolld->payroll_item,$emp->employeeSalary($emp->employee_id)->amount,$payrolld->amount);
                    }
                    $total = $total + $emp->employeeSalary($emp->employee_id)->amount + $empbenefits;
                    $totald = $totald + $empdeductions;
                  }
            $grandtotal = $grandtotal + $total;
            $grandtotald = $grandtotald + $totald;
            
            $annualreport[Carbon::parse($generation->payroll_date)->month-1] = number_format(($total - $totald),2,'.','');
        }
        $average = ($grandtotal - $grandtotald) / count($payrollgeneration);
        $employees = Employee::count();
        $projects = Project::where('completed',false)->count();
        return view('dashboard', compact(
            'annualreport',
            'average',
            'employees',
            'projects'
        ));
    }
}
