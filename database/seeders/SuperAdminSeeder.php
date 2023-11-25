<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = User::create([
            'names' => 'TrackFit',
            'email' => 'trackfit33@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('78&dD2@/?^d2A')
        ]);

        $role = Role::create(['name' => 'SUPERADMIN']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $superadmin->assignRole([$role->id]);
    }
}
