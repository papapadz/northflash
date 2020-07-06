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
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 5,
                'item' => 'Overtime Pay',
                'amount' => 0,
                'percentage' => 0,
                'type' => 1,
                'flexirate' => true,
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
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 7,
                'item' => '13th Month Pay',
                'amount' => 0,
                'percentage' => 0,
                'type' => 1,
                'flexirate' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ]);
    }
}
