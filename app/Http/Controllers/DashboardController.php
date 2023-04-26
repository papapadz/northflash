<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PayrollGeneration;
use App\Models\PayrollGenerationMaster;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Project;

class DashboardController extends Controller
{
    public function index(Request $request) {
      
        $now = Carbon::now();
        $annualreport = array(0,0,0,0,0,0,0,0,0,0,0,0);
        $total = 0;
        $grandtotal = 0;
        $employees = Employee::count();
        $projects = Project::where('completed',false)->count();
        $dateFrom = $now->startOfYear()->toDateString();
        $dateTo = $now->endOfYear()->toDateString();

        if($request->has('filter')) {
          $dateFrom = Carbon::parse($request->dateFrom)->toDateString();
          $dateTo = Carbon::parse($request->dateTo)->toDateString();
        }

        $payrollGenerationMaster = PayrollGenerationMaster::select()
            ->whereBetween('date_start',[$dateFrom,$dateTo])
            ->orderBy('date_start')
            ->get();
        
        foreach($payrollGenerationMaster as $generation) {
          
          $i = Carbon::parse($generation->date_start)->month - 1;
          $total = 0;
          foreach($generation->payrollList as $payroll) {
            $total += $payroll->total;
          }
          $grandtotal += $total;
          $annualreport[$i] = $annualreport[$i] + $total;
        }

        if(count($payrollGenerationMaster)>0)
          $average = $grandtotal/count($payrollGenerationMaster);
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
