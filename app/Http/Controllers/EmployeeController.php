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
use App\Models\FileHandler;
use App\Models\Education;
use App\Models\Family;

class EmployeeController extends Controller
{
    public function index() {

        $employees = Employee::get();
        $positions = Position::orderBy('title')->get();

        return view('pages.admin.employee.index')
            ->with([
                'employees' => $employees,
                'positions' => $positions
            ]);
    }

    public function getRegistrations() {
        $dateNow = Carbon::now();

        // Initialize cURL.
        $ch = curl_init();

        // Set the URL that you want to GET by using the CURLOPT_URL option.
        //curl_setopt($ch, CURLOPT_URL, 'http://localhost/nfpbv2/public/api/v2/get/registered');
        curl_setopt($ch, CURLOPT_URL, 'https://nfpb.binarybee.org/api/v2/get/registered');
        // Set CURLOPT_RETURNTRANSFER so that the content is returned as a variable.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Set CURLOPT_FOLLOWLOCATION to true to follow redirects.
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        // Execute the request.
        $data = curl_exec($ch);

        // Close the cURL handle.
        curl_close($ch);
        // // Print the data out onto the page.
        // echo $data;
        $employees = json_decode($data);

        foreach($employees as $k => $emp) {
            if(Employee::where('last_name',$emp->last_name)->where('first_name',$emp->first_name)->where('birthdate',$emp->birthdate)->first())
                unset($employees[$k]);
        }
        
        return view('pages.admin.employee.index2')
        ->with([
            'employees' => $employees
        ]);
    }

    public function sync() {
        $dateNow = Carbon::now();
        // Initialize cURL.
        $ch = curl_init();
        // Set the URL that you want to GET by using the CURLOPT_URL option.
        //curl_setopt($ch, CURLOPT_URL, 'http://localhost/nfpbv2/public/api/v2/get/registered');
        curl_setopt($ch, CURLOPT_URL, 'https://nfpb.binarybee.org/api/v2/get/registered');
        // Set CURLOPT_RETURNTRANSFER so that the content is returned as a variable.
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set CURLOPT_FOLLOWLOCATION to true to follow redirects.
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        // Execute the request.
        $data = curl_exec($ch);
        // Close the cURL handle.
        curl_close($ch);
        // // Print the data out onto the page.
        // echo $data;
        $employees = json_decode($data);

        foreach($employees as $employee) {
            
            $employee_id = $dateNow->year.'-'.''.str_pad(count(Employee::get())+1, 4, '0', STR_PAD_LEFT);

            $empData = Employee::where([
                ['first_name', title_case($employee->first_name)],
                ['middle_name', title_case($employee->middle_name)],
                ['last_name', title_case($employee->last_name)],
                ['birthdate', $employee->birthdate,]
            ])->first();

            if($empData)
                $employee_id = $empData->employee_id;

            $avatar = FileHandler::create([
                'file_type' => $employee->avatar->file_type,
                'url' => $employee->avatar->url
            ]);

            $emp = Employee::updateOrCreate([
                'employee_id' => $employee_id
            ],[
                'first_name' => title_case($employee->first_name),
                'middle_name' => title_case($employee->middle_name),
                'last_name' => title_case($employee->last_name),
                'birthdate' => $employee->birthdate,
                'gender' => $employee->gender,
                'civil_stat' => $employee->civil_stat,
                'address' => title_case($employee->address),
                'email' => $employee->email,
                'citizenship' => $employee->citizenship,
                'height' => $employee->height,
                'weight' => $employee->weight,
                'bloodType' => $employee->bloodType,
                'img' => $avatar->id
            ]);

            if($employee->education)
                foreach($employee->education as $education) {
                    Education::updateOrcreate([
                        'employee_id' => $employee_id,
                        'level' => $education->level,
                        'year' => $education->year
                    ],[
                        'school' => $education->school
                    ]);
                }

            if($employee->employment)
                foreach($employee->employment as $employment) {
                    $position = Position::firstOrCreate([
                        'title' => title_case($employment->salary->position->title),
                    ]);

                    $salary = Salary::firstOrCreate([
                        'position_id' => $position->id,
                        'amount' => $employment->salary->amount,
                        'date_effective' => $employment->date_hired,
                        'monthly' => $employment->salary->monthly,
                    ]);
                    
                    Employment::updateOrcreate([
                        'employee_id' => $employee_id,
                        'salary_id' => $salary->id,
                        'status' => $employment->status,
                        'company' => title_case($employment->company),
                        'date_hired' => $employment->date_hired,
                        'is_active' => $employment->company == "Northflash Power and Builds, Inc." ? true : false
                    ]);
                }
            else {
                $position = Position::firstOrCreate([
                    'title' => 'Helper',
                ]);

                $salary = Salary::firstOrCreate([
                    'position_id' => $position->id,
                    'amount' => 450,
                    'date_effective' => Carbon::now(),
                    'monthly' => false,
                ]);
                
                Employment::updateOrcreate([
                    'employee_id' => $employee_id,
                    'salary_id' => $salary->id,
                    'status' => 'COSW',
                    'company' => 'Northflash Power and Builds, Inc.',
                    'date_hired' => $salary->date_effective,
                    'is_active' => true
                ]);
            }
            
            $employmentDetails = Employment::where([['employee_id',$employee_id],['company','Northflash Power and Builds, Inc.']])->first();
            Payroll::updateOrcreate([
                'employee_id' => $employee_id,
                'payroll_item' => 8,
                'payroll_date_start' => $employmentDetails->date_hired,
                'amount' => $employmentDetails->salary->amount
            ]);

            $payrollController = new PayrollController;

            $OTRequest = new Request();
            $OTRequest->replace([
                'payroll_item' => 5,
                'emp_id' => $employee_id
            ]);
            Payroll::updateOrcreate([
                'employee_id' => $employee_id,
                'payroll_item' => 5,
                'payroll_date_start' => $employmentDetails->date_hired,
                'amount' => $payrollController->getPayrollItemAmt($OTRequest)
            ]);

            $UTRequest = new Request();
            $UTRequest->replace([
                'payroll_item' => 6,
                'emp_id' => $employee_id
            ]);
            Payroll::updateOrcreate([
                'employee_id' => $employee_id,
                'payroll_item' => 6,
                'payroll_date_start' => $employmentDetails->date_hired,
                'amount' => $payrollController->getPayrollItemAmt($UTRequest)
            ]);
            
            if($employee->family)
            foreach($employee->family as $family) {
                Family::updateOrCreate([
                    'employee_id' => $employee_id,
                    'relationship' => title_case($family->relationship)
                ],[
                    'name' => title_case($family->name),
                    'phone' => $family->phone,
                    'occupation' => title_case($family->occupation)
                ]);
            }

            if($employee->licenses)
            foreach($employee->licenses as $license) {
                
                License::updateOrCreate([
                    'employee_id' => $employee_id,
                    'license_type_id' => $license->license_type_id,
                ],[
                    'license_no' => title_case($license->license_no),
                    'date_issued' => $license->date_issued,
                    'date_expired' => $license->date_expired
                ]);
            }
        }
        return redirect()->back()->with('success','Sync success!');
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

                $employment = $this->storeemployment($request);
                
                Payroll::updateOrcreate([
                    'employee_id' => $request->employee_id,
                    'payroll_item' => 8,
                    'payroll_date_start' => $request->date_hired,
                    'amount' => $request->salary
                ]);

                $payrollController = new PayrollController;

                $OTRequest = new Request();
                $OTRequest->replace([
                    'payroll_item' => 5,
                    'emp_id' => $request->employee_id
                ]);
                Payroll::updateOrcreate([
                    'employee_id' => $request->employee_id,
                    'payroll_item' => 5,
                    'payroll_date_start' => $request->date_hired,
                    'amount' => $payrollController->getPayrollItemAmt($OTRequest)
                ]);

                $UTRequest = new Request();
                $UTRequest->replace([
                    'payroll_item' => 6,
                    'emp_id' => $request->employee_id
                ]);
                Payroll::updateOrcreate([
                    'employee_id' => $request->employee_id,
                    'payroll_item' => 6,
                    'payroll_date_start' => $request->date_hired,
                    'amount' => $payrollController->getPayrollItemAmt($UTRequest)
                ]);

                return redirect()->back()->with('success','Employee added!');
            }
            else
                return redirect()->back()->with('danger','Employee ID No. is already taken.');
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
        return Employee::where('employee_id',$employee_id)->with('payroll')->first();
        
    }

    public function addemployment(Request $request) {

        if($this->storeemployment($request)==0)
            return redirect()->back()->with('danger','Employment record already exists.');
        else
            return redirect()->back()->with('success','New employment record has been saved!');
    }

    private function storeemployment(Request $request) {

        $salary = Salary::firstOrCreate(
            [
                'position_id' => $request->position,
                'amount' => $request->salary,
                'date_effective' => $request->date_hired,
                'monthly' => $request->monthly
            ]
        );

        $employment = Employment::firstOrcreate(
            [
                'employee_id' => $request->employee_id,
                'salary_id' => $salary->id,
                'status' => $request->status,
                'date_hired' => $request->date_hired
            ]
        );

        if($employment->wasRecentlyCreated) {
            $empl = Employment::where([
                ['date_expired',null],
                ['id','!=',$employment->id],
                ['employee_id',$request->employee_id]
            ])->update(['date_expired' => Carbon::now()]);
        }
        return $employment;
    }

    public function updateemployment(Request $request) {
        
        $salary = Salary::firstOrCreate(
            [
                'position_id' => $request->position,
                'amount' => $request->salary,
                'date_effective' => $request->date_hired,
                'monthly' => $request->monthly
            ]
        );

        Employment::where('id',$request->employment_id)->update(
            [
                'salary_id' => $salary->id,
                'status' => $request->status,
                'date_hired' => $request->date_hired
            ]
        );

        return redirect()->back()->with('success','Employment record has been updated!');
    }

    public static function deleteEmployment($id) {

        Employment::where('id',$id)->update(['date_expired' => Carbon::now()]);
    }

    public function register(Request $request) {

        dd($request->all());
        
         $employee_id = $dateNow->year.'-'.''.str_pad(count(Employee::get())+1, 4, '0', STR_PAD_LEFT);
         $request->request->add(['employee_id' => $employee_id]);

         $positionController = new PositionController;
         $position = $positionController->findPosition($request->currentPosition);
 
         /** Create salary */
         $salary = Salary::create([
             'position_id' => $position->id,
             'amount' => $request->currentSalary,
             'date_effective' => $request->currentDateEmployed,
             'monthly' => $request->currentSalary > 5000 ? true : false
         ]);
 
         /** Create/Update Employee */
         $employee = Employee::updateOrCreate([
             'first_name' => $request->firstName,
             'last_name' => $request->lastName,
             'birthdate' => $request->dateOfBirth
         ],[
             'middle_name' => $request->middleName,
             'employee_id' => $employee_id,
             'gender' => $request->sex,
             'civil_Stat' => $request->civilStatus,
             'citizenship' => $request->citizenship,
             'address' => $request->address,
             'height' => $request->height,
             'weight' => $request->weight,
             'bloodType' => $request->bloodType,
             //'date_hired' => $request->currentDateEmployed,
             'email' => $request->emailAddress,
             //'position' => $position->id
             'civil_stat' => $request->civilStatus,
             'img' => $this->uploadFile($request->file('picture')),
             'entry_by' => Auth::User()->id
         ]);
 
         /** Create Education */
         if($request->has('education')) {
             foreach(json_decode($request->education) as $educ) {
                 if($educ->school) {
                     $myRequest = new Request();
                     $myRequest->replace([
                         'employee_id' => $employee_id,
                         'level' => $educ->level,
                         'school' => $educ->school,
                         'year' => $educ->year
                     ]);
                     $this->addEducation($myRequest);
                 }
             }
         }
 
         /** Create Current Employment */
         $employment = Employment::create([
             'employee_id' => $employee_id,
             'salary_id' => $salary->id,
             'status' => $salary->monthly ? 'Regular' : 'COSW',
             'date_hired' => $salary->date_effective,
             'company' => 'Northflash Power and Builds, Inc.',
             'is_active' => true
         ]);
 
         /** Create Previous Employment */
         if($request->has('workExperience')) {
             foreach(json_decode($request->workExperience) as $exp) {
                 if($exp->companyName) {
                     
                     $d = Carbon::now()->startOfYear();
                     $d->year = $exp->year;
                     
                     $expSalary = Salary::create([
                         'position_id' => $this->findPosition($exp->position)->id,
                         'amount' => $exp->salary,
                         'date_effective' => $d->toDateString(),
                         'monthly' => $exp->salary > 5000 ? true : false
                     ]);
 
                     $myRequest = new Request();
                     $myRequest->replace([
                         'employee_id' => $employee_id,
                         'salary_id' => $expSalary->id,
                         'status' => $expSalary ? 'Regular' : 'COSW',
                         'date_hired' => $expSalary->date_effective,
                         'company' => $exp->companyName
                     ]);
                     $workExp = $this->addWorkExp($myRequest);
                 }
             }
         }
 
         /** Add Family Background */
         if($request->has('spouseName')) {
             if($request->spouseName) {
                 Family::updateOrCreate([
                     'employee_id' => $employee_id,
                     'relationship' => 'Spouse',
                 ],[
                     'name' => $request->spouseName,
                     'phone' => $request->spousePhone,
                     'occupation' => $request->spouseOccupation
                 ]);
             }
         }
 
             Family::updateOrCreate([
                 'employee_id' => $employee_id,
                 'relationship' => 'Father',
             ],[
                 'name' => $request->fatherName,
             ]);
 
             Family::updateOrCreate([
                 'employee_id' => $employee_id,
                 'relationship' => 'Mother',
             ],[
                 'name' => $request->motherName,
             ]);
 
             if($request->has('eligibility') && $request->eligibility)
                 License::updateOrCreate([
                     'employee_id' => $employee_id,
                     'license_type_id' => 5
                 ],[
                     'license_no' => $request->eligibility,
                 ]);
 
             if($request->has('tin') && $request->tin)
                 License::updateOrCreate([
                     'employee_id' => $employee_id,
                     'license_type_id' => 1
                 ],[
                     'license_no' => $request->tin,
                 ]);
 
             if($request->has('pagibigIdNo') && $request->pagibigIdNo)
                 License::updateOrCreate([
                     'employee_id' => $employee_id,
                     'license_type_id' => 4
                 ],[
                     'license_no' => $request->pagibigIdNo
                 ]);
             
             if($request->has('philHealthNo') && $request->philHealthNo)
                 License::updateOrCreate([
                     'employee_id' => $employee_id,
                     'license_type_id' => 3
                 ],[
                     'license_no' => $request->philHealthNo
                 ]);
 
             if($request->has('sssNo') && $request->sssNo)
                 License::updateOrCreate([
                     'employee_id' => $employee_id,
                     'license_type_id' => 2
                 ],[
                     'license_no' => $request->sssNo
                 ]);
         
         return array(
             'code' => 'OK',
             'status' => $employee->wasRecentlyCreated ? 'UPDATED' : 'NEW',
             'employee_id' => $employee_id
         );
     }

    public function addEducation(Request $request) {
        $education = Education::updateOrCreate([
            'employee_id' => $request->employee_id,
            'level' => $request->level,
            'school' => $request->school,
            'year' => $request->year
        ]);

        return $education;
    }

    public function addWorkExp(Request $request) {
        $employment = Employment::updateOrCreate([
            'employee_id' => $request->employee_id,
            'company' => $request->company
        ],[
            'salary_id' => $request->salary_id,
            'status' => $request->status,
            'date_hired' => $request->date_hired,
        ]);

        return $employment;
    }

    
    public function uploadFile($image) {
        $filename = time() . '.' . $image->getClientOriginalExtension();
        Storage::disk('public')->putFileAs('uploads', $image, $filename);
        
        $fileObj = FileHandler::create([
            'file_type' => $image->getClientOriginalExtension(),
            'url' => asset('storage/uploads/'.$filename)
        ]);
        return $fileObj->id;
    }

    public function registration() {
        return view('pages.admin.employee.registration.index');
    }

    public function filter(Request $request) {
        
        $dataArray = [];
        $dataColumns = [];
        switch($request->flag) {
            case 1: 
                $employees = Employee::with('avatar')->get();
                foreach($employees as $employee) {
                    array_push($dataArray, array(
                        'id' => $employee->employee_id,
                        'name' => array(
                            'first_name' => $employee->first_name,
                            'last_name' => $employee->last_name,
                            'middle_name' => $employee->middle_name
                        ),
                        'birthdate' => Carbon::parse($employee->birthdate)->toDateString(),
                        'gender' => (($employee->gender=='M') ? 'Male' : 'F'),
                        'address' => $employee->address,
                        'email' => $employee->email,
                        'avatar' => $employee->avatar->url
                    ));
                }
                
                $columns = array(
                    array(
                        'label' => 'Employee ID',
                        'name' => 'employee_id',
                        'filter' => array('type' => 'simple', 'placeholder' => 'Enter Employee ID'),
                        'sort' => true
                    ),
                    array(
                        'label' => 'First Name',
                        'name' => 'name.first',
                        'filter' => array('type' => 'simple', 'placeholder' => 'Enter Employee ID'),
                        'sort' => true
                    ),
                );
                return $columns;
                break;
        }
        


        return $dataArray;
    }
}
