<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'employee_id';
    protected $casts = ['employee_id'=>'text']; 

    protected $fillable = [
        'employee_id',
        'first_name',
        'middle_name',
        'last_name',
        //'position',
        'birthdate',
        'gender',
        'civil_stat',
        'address',
        //'date_hired',
        'date_expired',
        'email',
        'citizenship',
        'height',
        'weight',
        'bloodType',
        'img'
    ];
    
    
    protected $dates = [
        'birthdate',
        'date_hired',
        'date_expired'
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/employees/'.$this->getKey());
    }

    /** NEW */
    public function employment() {
        return $this->hasOne(Employment::class,'employee_id','employee_id')->where('company','Northflash Power And Builds, Inc.');
    }

    public function payroll() {
        return $this->hasMany(Payroll::class,'employee_id','employee_id')->with('payrollItem');
    }

    public function payrollGenerations() {
        return $this->hasMany(PayrollGeneration::class,'employee_id','employee_id');
    }
    
    public function education() {
        return $this->hasMany(Education::class,'employee_id','employee_id');
    }

    public function employments() {
        return $this->hasMany(Employment::class,'employee_id','employee_id')->with('salary');
    }

    public function family() {
        return $this->hasMany(Family::class,'employee_id','employee_id');
    }

    public function licenses() {
        return $this->hasMany(License::class,'employee_id','employee_id')->with('type');
    }

    public function avatar() {
        return $this->hasOne(FileHandler::class,'id','img');
    }
    /** OLD */
    // public function payroll() {
    //     return $this->hasMany('App\Models\Payroll','employee_id','employee_id')
    //         ->join('payroll_items','payroll_items.id','=','payroll_item')
    //         ->orderBy('payroll_items.id');
    // }

    // public function employment() {
    //     return $this->hasOne('App\Models\Employment','employee_id','employee_id')
    //         ->join('salary','salary.id','=','salary_id')
    //         ->join('positions','positions.id','=','salary.position_id')
    //         ->orderBy('employments.created_at','desc');
    // }

    // public function licensenos() {
    //     return $this->hasMany('App\Models\License','employee_id','employee_id')
    //         ->join('license_types','license_types.id','=','license_type_id')
    //         ->orderBy('license_type_id');
    // }

    public function generations() {
        return $this->hasMany('App\Models\PayrollGeneration','employee_id','employee_id')
            ->select(
                'payroll_date',
                'payroll_items.amount as unit_amount',
                'num_days',
                'payroll_generations.amount as total_amount',
                'payroll_item',
                'item',
                'type'
            )
            ->join('payroll_items','payroll_items.id','=','payroll_generations.payroll_item');
    }

    public function projects() {
        return $this->hasMany('App\Models\ProjectAssignment','employee_id','employee_id')
            ->join('projects','projects.id','=','project_id');
    }

    // public function employments() {
    //     return $this->hasMany('App\Models\Employment','employee_id','employee_id')
    //         ->select('*','employments.id as employment_id')
    //         ->join('salary','salary.id','=','salary_id')
    //         ->join('positions','positions.id','=','salary.position_id');
    // }

    public function getEmploymentDetails($id) {
        return $this::select(
                'employments.employee_id',
                'amount',
                'position_id',
                'salary_id',
                'status',
                'date_hired',
                'date_expired',
                'monthly',
                'title'
            )
            ->join('employments','employments.employee_id','employees.employee_id')
            ->join('salary','salary.id','=','salary_id')
            ->join('positions','positions.id','=','salary.position_id')
            ->where('employments.id',$id)
            ->first();
    }
}
