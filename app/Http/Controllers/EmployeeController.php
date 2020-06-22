<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    public static function index() {

        $employees = Employee::ALL();

        return view('pages.admin.employee.index')->with('$employees');
    }
}
