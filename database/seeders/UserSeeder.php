<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::query()->firstOrCreate([
            'name' => 'Super Admin',
            'lastname' => 'Administrator',
            'email' => 'admin@delta2020.it'
        ],['password' => bcrypt('admin')]);

        $admin->syncRoles(\App\Helpers\Acl::ROLE_SUPERADMIN);
    }
}
