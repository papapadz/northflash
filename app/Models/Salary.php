<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $table = 'salary';

    protected $fillable = [
        'employment_id',
        'amount',
        'date_effective',
    
    ];
    
    
    protected $dates = [
        'date_effective',
        'created_at',
        'updated_at',
    
    ];

    protected $casts = [
        'amount' => 'decimal'
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/salaries/'.$this->getKey());
    }
}
