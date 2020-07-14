<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $table = 'salary';

    protected $fillable = [
        'position_id',
        'amount',
        'date_effective',
    
    ];
    
    
    protected $dates = [
        'date_effective'
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/salaries/'.$this->getKey());
    }
}
