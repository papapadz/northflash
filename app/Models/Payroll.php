<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $table = 'payroll';

    protected $fillable = [
        'employee_id',
        'payroll_item',
        'payroll_date_start'
    ];
    
    
    protected $dates = [
        'payroll_date_start'
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/payrolls/'.$this->getKey());
    }

    public function employee() {
        return $this->belongsTo('App\Models\Employee','employee_id','employee_id');
    }

}
