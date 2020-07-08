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

            $payroll = Payroll::updateOrInsert(
                [
                    'employee_id' => $request->employee_id,
                    'payroll_item' => $item
                ],
                [
                    'payroll_date_start' => $request->payroll_date_start,
                    'payroll_date_end' => $date_end
                ]
            );
        }

        return redirect()->back()->with('success','Record has been added!');
    }

    public function generations() {

        $payrollGenerations = PayrollGeneration::select('payroll_date','payroll_date_to')->groupBy('payroll_date','payroll_date_to')->get();

        return view('pages.admin.payroll.generations.index')
            ->with('payrollGenerations',$payrollGenerations);
    }

    public function generateview(Request $request) {

        $date_start = Carbon::parse($request->payroll_date_start)->toDateString();
        $date_end = Carbon::parse($request->payroll_date_end)->toDateString();
        
        $employees = Employee::select(
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
        ->whereDate('payroll_date_start','>=',$date_start)
        ->get();

        return view('pages.admin.payroll.generations.generate')
            ->with([
                'payroll_date_start' => $date_start,
                'payroll_date_end' => $date_start,
                'employees' => $employees
            ]);
    }

    public function save(Request $request) {

        $payroll_date = Carbon::parse($request->payroll_date_start)->toDateString();
        $payroll_date_to = Carbon::parse($request->payroll_date_end)->toDateString();

        foreach($request->emp as $k => $emp) {

            $generate = PayrollGeneration::updateOrCreate(
                [
                    'employee_id' => $emp,
                    'payroll_date' => $payroll_date
                ],
                [
                    'payroll_date_to' => $payroll_date_to,
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
        $payslip = 'payslip-'.$payroll_date.'.pdf';
        $pdf = DOMPdf::loadView('include.payroll.payslip',compact('data'))->setPaper('letter', 'portrait');
        return $pdf->download($payslip);
    }
}
