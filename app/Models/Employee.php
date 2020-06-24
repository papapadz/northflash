<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{

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
        'date_expired',
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/employees/'.$this->getKey());
    }
}
