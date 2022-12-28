<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PayrollGeneration;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Project;

class DashboardController extends Controller
{
    public function index(Request $request) {

        $now = Carbon::now();
        $annualreport = array(0,0,0,0,0,0,0,0,0,0,0,0);
        $total = $grandtotal = 0;
        $employees = Employee::count();
        $projects = Project::where('completed',false)->count();
        $dateFrom = $now->startOfYear()->toDateString();
        $dateTo = $now->endOfYear()->toDateString();

        if($request->has('filter')) {
          $dateFrom = Carbon::parse($request->dateFrom)->toDateString();
          $dateTo = Carbon::parse($request->dateTo)->toDateString();
        }

        $payrollgeneration = PayrollGeneration::select('payroll_date')
          ->whereBetween('payroll_date',[$dateFrom,$dateTo])
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

        
        return view('dashboard', compact(
            'annualreport',
            'average',
            'employees',
            'projects',
            'dateFrom',
            'dateTo'
        ));
    }
}
