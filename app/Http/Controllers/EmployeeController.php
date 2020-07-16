<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Employment;
use App\Models\Salary;
use App\Models\LicenseType;
use App\Models\License;
use App\Models\Payroll;

class EmployeeController extends Controller
{
    public function index() {

        $employees = Employee::select()
            ->orderBy('last_name')
            ->get();
        $positions = Position::orderBy('title')->get();

        return view('pages.admin.employee.index')
            ->with([
                'employees' => $employees,
                'positions' => $positions
            ]);
    }

    public function store(Request $request) {

        try {

            $employee = Employee::where('employee_id',$request->employee_id)->withTrashed()->first();

            if(!$employee) {
                $employee = Employee::firstOrCreate(
                    ['employee_id' => $request->employee_id ],
                    [
                        'first_name' => $request->first_name,
                        'middle_name' => $request->middle_name,
                        'last_name' => $request->last_name,
                        'birthdate' => $request->birthdate,
                        'gender' => $request->gender,
                        'civil_stat' => $request->civil_stat,
                        'address' => $request->address,
                    ]
                );
            } else
                return redirect()->back()->with('danger','Employee ID No. already taken.');

            if($employee->wasRecentlyCreated) {

                $salary = Salary::firstOrCreate(
                    [
                        'position_id' => $request->position,
                        'amount' => $request->salary,
                        'date_effective' => $request->date_hired,
                        'monthly' => $request->monthly
                    ]
                );
                
                Employment::create([
                    'employee_id' => $request->employee_id,
                    'salary_id' => $salary->id,
                    'status' => $request->status,
                    'date_hired' => $request->date_hired
                ]);
                
                Payroll::create([
                    'employee_id' => $request->employee_id,
                    'payroll_item' => 8,
                    'payroll_date_start' => $request->date_hired
                ]);

                return redirect()->back()->with('success','Employee added!');
            }
            else
                return redirect()->back()->with('danger','Employee ID No. already taken.');
        } catch(Exception $e) {
            return redirect()->back()->with('error',$e);
        }
    }

    public function updatebasic(Request $request) {
        Employee::where('employee_id',$request->employee_id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'middle_name' => $request->middle_name,
            'birthdate' => $request->birthdate,
            'gender' => $request->gender,
            'civil_stat' => $request->civil_stat,
            'address' => $request->address,
        ]);

        return redirect()->back()->with('success','Employee details has been updated successfully!');
    }

    public static function delete($id) {
        
        $employment = Employment::where('employee_id',$id)->orderBy('date_hired','desc')->first();
        $employment->update(['date_expired' => Carbon::now()]);
        Employee::find($id)->delete();
    }

    public function view($employee_id) {

        $employee = Employee::find($employee_id);

        return view('pages.admin.employee.profile')->with([
                'employee' => $employee,
                'licensetypes' => LicenseType::all(),
                'positions' => Position::all()
            ]);
    }

    public function addlicense(Request $request) {

        License::updateOrCreate(
            [
                'license_type_id' => $request->license_type_id,
                'employee_id' => $request->employee_id
            ],
            [
                'license_no' => $request->license_no,
                'date_issued' => $request->date_issued,
                'date_expired' => $request->date_expired
            ]
        );
        
        return redirect()->back()->with('success','Record has been added!');
    }

    public function getEmployeePayroll($employee_id) {
        $employee = Employee::find($employee_id);
        $payroll = $employee->payroll;
        return $payroll;
    }
}
