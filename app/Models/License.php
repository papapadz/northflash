<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    protected $fillable = [
        'employee_id',
        'license_type_id',
        'license_no',
        'date_issued',
        'date_expired',
    ];
    
    
    protected $dates = [
        'date_issued',
        'date_expired'
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/licenses/'.$this->getKey());
    }
}
