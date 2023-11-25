<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    Role::create(['guard_name' => 'web', 'name' => 'ADMIN']);
    Role::create(['guard_name' => 'api', 'name' => 'USER']);
    // Role::create(['name' => 'SUPERADMIN']);

    }
}
