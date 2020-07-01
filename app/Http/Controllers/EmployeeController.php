<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Employment;
use App\Models\Salary;

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

                $employment = Employment::firstOrCreate([
                    'employee_id' => $request->employee_id,
                    'position_id' => $request->position,
                    'status' => $request->status,
                    'date_hired' => $request->date_hired
                ]);

                $salary = Salary::create(
                    [
                        'employment_id' => $employment->id,
                        'amount' => $request->salary,
                        'date_effective' => $request->date_hired
                    ]
                );

                return redirect()->back()->with('success','Employee added!');
            }
            else
                return redirect()->back()->with('danger','Employee ID No. already taken.');
        } catch(Exception $e) {
            return redirect()->back()->with('error',$e);
        }
    }
}
