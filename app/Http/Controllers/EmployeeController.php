<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Employment;
use App\Models\Salary;

class EmployeeController extends Controller
{
    public static function index() {

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

    public static function store(Request $request) {

        try {
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
            
            if($employee) {

                $salary = Salary::firstOrCreate(
                    [
                        'position_id' => $request->position,
                        'amount' => $request->salary,
                        'date_effective' => $request->date_hired
                    ]
                );
                
                $employment = Employment::create([
                    'employee_id' => $request->employee_id,
                    'salary_id' => $salary->id,
                    'status' => $request->status,
                    'date_hired' => $request->date_hired
                ]);

                return redirect()->back()->with('success','Employee added!');
            }
            else
                return redirect()->back()->with('danger','Employee ID No. already taken.');
        } catch(Exception $e) {
            return redirect()->back()->with('error',$e);
        }
    }
}
