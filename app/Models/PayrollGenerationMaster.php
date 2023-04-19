<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollGenerationMaster extends Model
{
    //

    protected $fillable = [
        'generated_by',
        'date_start',
        'date_end',
        'project_id'
    ];

    public function payrollList() {
        return $this->hasMany(PayrollGeneration::class,'payroll_master_id','id')->with('payrollItem');
    }

    public function project() {
        return $this->hasOne(Project::class,'id','project_id');
    }
}
