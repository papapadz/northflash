<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dtr extends Model
{
    protected $table = 'dtr';

    protected $fillable = [
        'employee_id',
        'type',
    
    ];
        
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/dtrs/'.$this->getKey());
    }
}
