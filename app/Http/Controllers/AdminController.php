<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AdminController extends Controller
{
    public function crud(Request $request) {

        switch($request->crud) {

            case 3:
                $this->delete($request->tbl,$request->id);
            break;
        }
    }

    private function delete($tbl,$id) {

        switch($tbl) {
            case 'positions':
                PositionController::delete($id);
            break;

            case 'employees':
                EmployeeController::delete($id);

            break;

            case 'payroll_items':
                PayrollItemController::delete($id);
            break;

            case 'payroll':
                PayrollController::deletePayroll($id);
            break;

            case 'payroll_generations':
                PayrollController::deletePayrollGeneration($id);
            break;
            
            case 'employment':
                EmployeeController::deleteEmployment($id);
            break;
        }
    }

    public function redirect($id) {
        switch($id) {
            case 3:
                return redirect()->back()->with('danger','Record has been deleted.');
            break;
        }
    }

    public function logout() {
        
        Auth::logout();
        return redirect()->route('home');
    }
}
