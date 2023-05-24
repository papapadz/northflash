<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            array('id' => 1, 'role' => 'User'),
            array('id' => 2, 'role' => 'Manager'),
            array('id' => 3, 'role' => 'Administrator'),
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate([
                'id' => $role['id'],
            ],[
                'role' => $role['role']
            ]
        );
        }
    }
}
