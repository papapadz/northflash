<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollItem extends Model
{
    protected $fillable = [
        'item',
        'amount',
        'percentage',
        'type',
        'flexirate',
        'date_effective',
    ];
    
    
    protected $dates = [
        'date_effective',
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/payroll-items/'.$this->getKey());
    }
}
