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
        $total = $grandtotal = 0;

        $payrollgeneration = PayrollGeneration::select('payroll_date')
          ->whereBetween('payroll_date',[$now->startOfYear()->toDateString(),$now->endOfYear()->toDateString()])
          ->groupBy('payroll_date')
          ->get();
        
        foreach($payrollgeneration as $generation) {
          $total = $generation->monthlySalaryAmount($generation->payroll_date) - $generation->monthlyDeductionAmount($generation->payroll_date);
          $grandtotal = $grandtotal + $total;
          $annualreport[Carbon::parse($generation->payroll_date)->month-1] = $annualreport[Carbon::parse($generation->payroll_date)->month-1] + $total;
        }

        if(count($payrollgeneration))
          $average = $grandtotal / count($payrollgeneration);
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
}
