<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use DOMPdf;
use App\Models\Payroll;
use App\Models\PayrollItem;
use App\Models\Employee;
use App\Models\PayrollGeneration;

class PayrollController extends Controller
{
    public function index() {

        $employeePayrolls = Employee::select(
                'employees.employee_id',
                'last_name',
                'first_name',
                'middle_name',
                'payroll_date_start',
                'payroll_date_end'
            )
            ->join('payroll','payroll.employee_id','=','employees.employee_id')
            ->groupBy(
                    'employees.employee_id',
                    'last_name',
                    'first_name',
                    'middle_name',
                    'payroll_date_start',
                    'payroll_date_end'
                )
            ->get();

        $payrollItems1 = PayrollItem::select('id','item','type')->orderBy('item')->where('type',1)->get();
        $payrollItems2 = PayrollItem::select('id','item','type')->orderBy('item')->where('type',2)->get();
            
        $employees = Employee::select('employee_id','first_name','last_name')->orderBy('last_name')->get();
        
        return view('pages.admin.payroll.index')
            ->with([
                'employeePayrolls' => $employeePayrolls,
                'payrollItems1' => $payrollItems1,
                'payrollItems2' => $payrollItems2,
                'employees' => $employees
            ]);
    }

    public function store(Request $request) {

        $err[] = null;

        $date_end = null;
        if($request->repeat==2)
            $date_end = $request->payroll_date_end;
        
        foreach($request->item as $item) {

            $payroll = Payroll::firstOrCreate(
                [
                    'employee_id' => $request->employee_id,
                    'payroll_item' => $item,
                    'payroll_date_start' => $request->payroll_date_start
                ],
                [
                    'payroll_date_end' => $date_end
                ]
            );

            if(!$payroll)
                array_push($err,$item);
        }

        if(count($err)>0)
            return redirect()->back()->with('err',$err);
        else
            return redirect()->back()->with('success','Record has been added!');
    }

    public function generations() {

        $payrollGenerations = PayrollGeneration::select('payroll_date')->groupBy('payroll_date')->get();

        return view('pages.admin.payroll.generations.index')
            ->with('payrollGenerations',$payrollGenerations);
    }

    public function generateview(Request $request) {

        $employees = Employee::select(
            'employees.employee_id',
            'last_name',
            'first_name',
            'middle_name',
            'payroll_date_start',
            'payroll_date_end'
        )
        ->join('payroll','payroll.employee_id','=','employees.employee_id')
        ->join('employments','employments.employee_id','=','employees.employee_id')
        ->groupBy(
                'employees.employee_id',
                'last_name',
                'first_name',
                'middle_name',
                'payroll_date_start',
                'payroll_date_end'
            )
        ->whereDate('date_hired','<=',$request->payroll_date)
        ->get();

        return view('pages.admin.payroll.generations.generate')
            ->with([
                'payroll_date' => $request->payroll_date,
                'employees' => $employees
            ]);
    }

    public function save(Request $request) {

        $pmonth = Carbon::parse($request->payroll_date);
        $payroll_date = new Carbon('first day of '.$pmonth->englishMonth.' '.$pmonth->year);

        foreach($request->emp as $k => $emp) {

            $generate = PayrollGeneration::updateOrCreate(
                [
                    'employee_id' => $emp,
                    'payroll_date' => $payroll_date->toDateString()
                ],
                [
                    'regular_days' => $request->reg[$k],
                    'ot' => $request->ot[$k],
                    'ut' => $request->ut[$k],
                    'generated_by' => Auth::user()->id
                ]
            );
        }

        return $this->generations();
    }

    public function payslip($payroll_date) {
        $data = PayrollGeneration::select()->whereDate('payroll_date',$payroll_date)->get();
        $filename = 'payslip'.$payroll_date.'.pdf';
        $pdf = DOMPdf::loadView('include.payroll.payslip',compact('data'))->setPaper('letter', 'portrait');
        return $pdf->download($filename);
    }
}
