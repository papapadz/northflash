<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Models\PayrollItem;

class PayrollItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payrollItems = array([
            'id' => 1,
            'item' => 'Tax',
            'amount' => 0,
            'percentage' => 0,
            'type' => 2,
            'flexirate' => true,
            'deduction_period' => 16
        ],
        [
            'id' => 2,
            'item' => 'SSS',
            'amount' => 0,
            'percentage' => 0,
            'type' => 2,
            'flexirate' => true,
            'deduction_period' => 1
        ],
        [
            'id' => 3,
            'item' => 'PhilHealth',
            'amount' => 0,
            'percentage' => 0,
            'type' => 2,
            'flexirate' => true,
            'deduction_period' => 1
        ],
        [
            'id' => 4,
            'item' => 'PagIBIG',
            'amount' => 100,
            'percentage' => 0,
            'type' => 2,
            'flexirate' => false,
            'deduction_period' => 1
        ],
        [
            'id' => 5,
            'item' => 'Overtime Pay',
            'amount' => 0,
            'percentage' => 0.30,
            'type' => 1,
            'flexirate' => true,
            'deduction_period' => 0,
            'unit' => 'hr',
            'is_manual_entry' => true
        ],
        [
            'id' => 6,
            'item' => 'Undertime',
            'amount' => 0,
            'percentage' => 0,
            'type' => 2,
            'flexirate' => true,
            'deduction_period' => 0,
            'unit' => 'min',
            'is_manual_entry' => true
        ],
        [
            'id' => 7,
            'item' => '13th Month Pay',
            'amount' => 0,
            'percentage' => 1,
            'type' => 1,
            'flexirate' => true,
            'deduction_period' => 1
        ],
        [
            'id' => 8,
            'item' => 'Salary/Wage',
            'amount' => 0,
            'percentage' => 0,
            'type' => 1,
            'flexirate' => true,
            'deduction_period' => 0
        ]);

        foreach($payrollItems as $item)
            PayrollItem::updateOrcreate([
                'id' => $item['id']
            ],$item);
    }
}
