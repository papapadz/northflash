<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payroll extends Model
{
    use SoftDeletes;

    protected $table = 'payroll';

    protected $fillable = [
        'employee_id',
        'payroll_item',
        'payroll_date_start',
        'payroll_date_end',
        'amount'
    ];
    
    
    protected $dates = [
        'payroll_date_start',
        'payroll_date_end'
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

    public function payrollItem() {
        return $this->hasOne(PayrollItem::class,'id','payroll_item');
    }
}
