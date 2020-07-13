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
                    /** for additions */
                    $ctr = 0;
                    do {

                      foreach($emp->employeePayroll(Carbon::parse($generation->payroll_date)->toDateString(),$emp->employee_id,1,$ctr) as $payroll) {
                      
                        if($payroll->payroll_item == 7 && (Carbon::parse($generation->payroll_date)->month == 5 || Carbon::parse($generation->payroll_date)->month == 11)) {
                          $empbenefits = $empbenefits + ($emp->employeeSalary($emp->employee_id)->amount/2);
                        } else if($payroll->payroll_item != 7) {
                            if($payroll->payroll_item == 5)
                              $empbenefits = $empbenefits + (findPayroll($payroll->payroll_item,$emp->employeeSalary($emp->employee_id)->amount,$payroll->amount,$emp->employeeSalary($emp->employee_id)->monthly) * $emp->ot);
                            else
                              $empbenefits = $empbenefits + findPayroll($payroll->payroll_item,$emp->employeeSalary($emp->employee_id)->amount,$payroll->amount,$emp->employeeSalary($emp->employee_id)->monthly);
                          }
                      }
                      $ctr++;
                      if($ctr==2)
                        $ctr = 16;
                    } while($ctr>16);
                    
                     /** for deductions */
                     $ctr = 0;
                     do {

                      foreach($emp->employeePayroll(Carbon::parse($generation->payroll_date)->toDateString(),$emp->employee_id,2,$ctr) as $payrolld) {
                        if($payroll->payroll_item == 6)
                          $empdeductions = $empdeductions + (findPayroll($payrolld->payroll_item,$emp->employeeSalary($emp->employee_id)->amount,$payrolld->amount,$emp->employeeSalary($emp->employee_id)->monthly) * $emp->ut);
                        else
                          $empdeductions = $empdeductions + findPayroll($payrolld->payroll_item,$emp->employeeSalary($emp->employee_id)->amount,$payrolld->amount,$emp->employeeSalary($emp->employee_id)->monthly);
                      }
                      $ctr++;
                      if($ctr==2)
                        $ctr = 16;
                    } while($ctr>16);

                    if($emp->employeeSalary($emp->employee_id)->monthly)
                      $salary = $emp->employeeSalary($emp->employee_id)->amount/2;
                    else
                      $salary = $emp->employeeSalary($emp->employee_id)->amount * $emp->regular_days;
                    $total = $total + $salary + $empbenefits;
                    $totald = $totald + $empdeductions;
                  }
            $grandtotal = $grandtotal + $total;
            $grandtotald = $grandtotald + $totald;
            
            if($annualreport[Carbon::parse($generation->payroll_date)->month-1]>0)
              $annualreport[Carbon::parse($generation->payroll_date)->month-1] = $annualreport[Carbon::parse($generation->payroll_date)->month-1] + number_format(($total - $totald),2,'.','');
            else
              $annualreport[Carbon::parse($generation->payroll_date)->month-1] = number_format(($total - $totald),2,'.','');
                  
          }
        
        if(count($payrollgeneration))
          $average = ($grandtotal - $grandtotald) / count($payrollgeneration);
        else
          $average = 0;
        $employees = Employee::count();
        $projects = Project::where('completed',false)->count();
        return view('dashboard', compact(
            'annualreport',
            'average',
            'employees',
            'projects'
        ));
    }

    public function getMonthlyPayroll($payroll_date) {
      $start_date = Carbon::parse($payroll_date)->startOfMonth()->toDateString();
      $end_date = Carbon::parse($payroll_date)->endOfMonth()->toDateString();

      $employeelist = PayrollGeneration::whereBetween('payroll_date',[$start_date,$end_date])->get();
      
      $total = $totald = 0;
      foreach($employeelist as $emp) {
        foreach($emp->monthlyPayroll($payroll_date,$emp->employee_id) as $payroll) {
          if($payroll->type==1) {
            if($payroll->payroll_item == 7 && (Carbon::parse($generation->payroll_date)->month == 5 || Carbon::parse($generation->payroll_date)->month == 11))
              $total = $total + ($emp->employeeSalary($emp->employee_id)->amount/2);
            else if($payroll->payroll->item != 7) {
              if($payroll->payroll_item==5)
                $total = $total + (findPayroll($payroll->payroll_item,$emp->employeeSalary($emp->employee_id)->amount,$payroll->amount) * $emp->ot);
           
            }
          }
        }
      }
    }
}
