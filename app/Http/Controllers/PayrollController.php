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
use App\Models\Employment;

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

        $payrollItems1 = PayrollItem::select('id','item','type')->orderBy('item')->where([['type','=',1],['id','!=',8]])->get();
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

        if($request->item) {
            foreach($request->item as $item) {

                $payroll = Payroll::updateOrInsert(
                    [
                        'employee_id' => $request->employee_id,
                        'payroll_item' => $item,
                        'payroll_date_start' => Employee::find($request->employee_id)->employment->date_hired
                    ]
                );
            }
    
            return redirect()->back()->with('success','New payroll record has been added!');
        }
        return redirect()->back()->with('danger','No payroll item selected! Please select at least 1.');
    }

    public function update(Request $request) {
        
        if($request->item) {
            foreach($request->item as $item) {

                $payroll = Payroll::updateOrInsert(
                    [
                        'employee_id' => $request->employee_id,
                        'payroll_item' => $item,
                        'payroll_date_start' => Employee::find($request->employee_id)->employment->date_hired
                    ]
                );
            }
            
            return redirect()->back()->with('success','Payroll record has been updated!');
        }
        return redirect()->back()->with('danger','No payroll item selected! Please select at least 1.');
    }

    public function generations() {
     
        $payrollGenerations = PayrollGeneration::select('payroll_date')->groupBy('payroll_date')->get();
        
        if(Payroll::count()==0)
            return redirect()->back()->with('danger','Please set first the payroll items for your employees');

        return view('pages.admin.payroll.generations.index')
            ->with('payrollGenerations',$payrollGenerations);
    }

    public function generateview(Request $request) {
        
        $payroll_date = Carbon::create($request->year,$request->month,$request->period)->toDateString();
        
        $employees = Employment::select(
                'employees.employee_id',
                'last_name',
                'first_name',
                'middle_name',
                'payroll_date_start',
                'payroll_date_end'
            )
            ->join('employees','employees.employee_id','=','employments.employee_id')
            ->join('payroll','payroll.employee_id','=','employees.employee_id')
            ->groupBy(
                'employees.employee_id',
                'last_name',
                'first_name',
                'middle_name',
                'payroll_date_start',
                'payroll_date_end'
            )
            ->where('date_expired', NULL)
            ->where('date_hired','<=',$payroll_date)
            ->get();
            
        // $employees = Employee::select(
        //     'employees.employee_id',
        //     'last_name',
        //     'first_name',
        //     'middle_name',
        //     'payroll_date_start',
        //     'payroll_date_end'
        // )
        // ->join('payroll','payroll.employee_id','=','employees.employee_id')
        // ->groupBy(
        //         'employees.employee_id',
        //         'last_name',
        //         'first_name',
        //         'middle_name',
        //         'payroll_date_start',
        //         'payroll_date_end'
        //     )
        // ->whereDate('payroll_date_start','>=',$payroll_date)
        // ->get();

        return view('pages.admin.payroll.generations.generate')
            ->with([
                'payroll_date' => $payroll_date,
                'employees' => $employees
            ]);
    }

    public function save(Request $request) {

        $payroll_date = Carbon::parse($request->payroll_date);

        foreach($request->emp as $k => $emp) {
        
            $employee = Employee::find($emp);

            if($payroll_date->day==1)
                $emppayroll = $employee->payroll->whereIn('deduction_period',[1,0]);
            else 
                $emppayroll = $employee->payroll->whereIn('deduction_period',[16,0]);

            foreach($emppayroll as $payroll) {
                $num_days = 1;
                $amount = findPayroll($payroll->payroll_item,$employee->employment->amount,$payroll->amount,$employee->employment->monthly);

                if($payroll->payroll_item==7 && ($payroll_date->month == 5 || $payroll_date->month == 11)) {
                    $this->savePayrollGeneration($emp,$payroll->payroll_item,$payroll_date->toDateString(),$amount,$num_days);
                } else if($payroll->payroll_item != 7) {

                    switch($payroll->payroll_item) {
                        case 8:
                            if($employee->employment->monthly)
                                $amount = $amount/2;
                            else
                                $amount = $amount * $request->reg[$k];
                            $num_days = $request->reg[$k];
                        break;

                        case 5:
                            $amount = $amount * $request->ot[$k];
                            $num_days = $request->ot[$k];
                        break;

                        case 6:
                            $amount = $amount * $request->ut[$k];
                            $num_days = $request->ut[$k];
                        break;
                    }
                    
                    $this->savePayrollGeneration($emp,$payroll->payroll_item,$payroll_date->toDateString(),$amount,$num_days);
                }
            }
            
        }

        return redirect()->route('generations.index')->with('success','Payroll has been saved!');
    }

    private function savePayrollGeneration($employee_id,$payroll_item,$payroll_date,$amount,$num_days) {

        PayrollGeneration::updateOrCreate(
            [
                'employee_id' => $employee_id,
                'payroll_date' => $payroll_date,
                'payroll_item' => $payroll_item
            ],
            [
                'amount' => $amount,
                'num_days' => $num_days,
                'generated_by' => Auth::user()->id
            ]
        );
    }

    public function payslip($payroll_date) {
        $data = PayrollGeneration::select('employee_id','payroll_date')->whereDate('payroll_date',$payroll_date)->groupBy('employee_id','payroll_date')->get();
        
        $payslip = 'payslip-'.$payroll_date.'.pdf';
        $pdf = DOMPdf::loadView('include.payroll.payslip',compact('data'))->setPaper('letter', 'portrait');
        return $pdf->download($payslip);
    }

    public static function deletePayroll($employee_id) {
        Payroll::where('employee_id',$employee_id)->delete();
    }

    public static function deletePayrollGeneration($payroll_date) {
        PayrollGeneration::where('payroll_date',$payroll_date)->delete();
    }
}
