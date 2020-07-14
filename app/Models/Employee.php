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
        'position',
        'birthdate',
        'gender',
        'civil_stat',
        'address',
        'date_hired',
        'date_expired',
    
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

    public function payroll() {
        return $this->hasMany('App\Models\Payroll','employee_id','employee_id')
            ->join('payroll_items','payroll_items.id','=','payroll_item')
            ->orderBy('payroll_items.id');
    }

    public function employment() {
        return $this->hasOne('App\Models\Employment','employee_id','employee_id')
            ->join('salary','salary.id','=','salary_id')
            ->join('positions','positions.id','=','salary.position_id')
            ->orderBy('employments.created_at','desc');
    }

    public function licensenos() {
        return $this->hasMany('App\Models\License','employee_id','employee_id')
            ->join('license_types','license_types.id','=','license_type_id')
            ->orderBy('license_type_id');
    }
}
