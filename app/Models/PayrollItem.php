<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayrollItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'item',
        'amount',
        'percentage',
        'type',
        'flexirate',
        'deduction_period',
        'unit',
        'is_manual_entry'
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/payroll-items/'.$this->getKey());
    }
}
