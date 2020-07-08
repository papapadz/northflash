<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LicenseTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('license_types')->insert([
            [
                'id' => 1,
                'type' => 'Tax Identification Number',
                'government' => true,
                'remarks' => "is a unique set of numbers assigned to each registered taxpayer in the Philippines. It's a fundamental requirement every time you transact with the Bureau of Internal Revenue (BIR), hence the need to apply for it as soon as you enter the workforce",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 2,
                'type' => 'Social Security System',
                'government' => true,
                'remarks' => "a state-run, social insurance program in the Philippines to workers in the private, professional and informal sectors. SSS is established by virtue of Republic Act No.1161, better known as the Social Security Act of 1954",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 3,
                'type' => 'Philippine Health Insurance Corporation',
                'government' => true,
                'remarks' => "a Government Owned and Controlled Corporation (GOCC) created through the National Health Insurance (NHI) Act of 1995 or Republic Act 7875",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 4,
                'type' => 'Pag-IBIG',
                'government' => true,
                'remarks' => "an acronym which stands for Pagtutulungan sa Kinabukasan: Ikaw, Bangko, Industria at Gobyerno. To this day, the Pag-IBIG Fund continues to harness these four sectors of the society to work together towards providing Fund members with adequate housing through an effective savings scheme",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'id' => 5,
                'type' => 'Professional Regulation Commission',
                'government' => true,
                'remarks' => "otherwise known as the PRC, is a three-man commission attached to Department of Labor and Employment (DOLE)",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
