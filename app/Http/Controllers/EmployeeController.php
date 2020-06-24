<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Position;

class EmployeeController extends Controller
{
    public static function index() {

        $employees = Employee::all();
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
                    'position' => $request->position,
                    'birthdate' => $request->birthdate,
                    'gender' => $request->gender,
                    'civil_stat' => $request->civil_stat,
                    'address' => $request->address,
                    'date_hired' => $request->date_hired,
                ]
            );
            
            if($employee)
                return redirect()->back()->with('success','Employee added!');
            else
                return redirect()->back()->with('danger','Employee ID No. already taken.');
        } catch(Exception $e) {
            return redirect()->back()->with('error',$e);
        }
    }
}
