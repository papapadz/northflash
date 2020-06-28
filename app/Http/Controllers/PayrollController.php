<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payroll;
use App\Models\PayrollItem;
use App\Models\Employee;

class PayrollController extends Controller
{
    public static function index() {

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

        $payrollItems = PayrollItem::select('id','item')->orderBy('item')->get();
        
        $employees = Employee::select('employee_id','first_name','last_name')->orderBy('last_name')->get();
        
        return view('pages.admin.payroll.index')
            ->with([
                'employeePayrolls' => $employeePayrolls,
                'payrollItems' => $payrollItems,
                'employees' => $employees
            ]);
    }

    public static function store(Request $request) {

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
}
