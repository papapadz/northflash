<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PayrollItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payroll_items')->insert([
            [
                'id' => 1,
                'item' => 'Tax',
                'amount' => 0,
                'percentage' => 0,
                'type' => 2,
                'flexirate' => true,
                'date_effective' => '2018-01-01',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 2,
                'item' => 'SSS',
                'amount' => 0,
                'percentage' => 0,
                'type' => 2,
                'flexirate' => true,
                'date_effective' => '2019-04-01',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 3,
                'item' => 'PhilHealth',
                'amount' => 0,
                'percentage' => 0,
                'type' => 2,
                'flexirate' => true,
                'date_effective' => '2018-01-01',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 4,
                'item' => 'PagIBIG',
                'amount' => 100,
                'percentage' => 0,
                'type' => 2,
                'flexirate' => false,
                'date_effective' => '2020-01-01',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 5,
                'item' => 'Overtime Pay',
                'amount' => 0,
                'percentage' => 0,
                'type' => 1,
                'flexirate' => false,
                'date_effective' => '2020-01-01',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 6,
                'item' => 'Undertime',
                'amount' => 0,
                'percentage' => 0,
                'type' => 2,
                'flexirate' => false,
                'date_effective' => '2020-01-01',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
