<?php

namespace Database\Seeders;

use App\Helpers\Acl;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = Acl::roles();
        foreach($roles as $role){
            Role::query()->firstOrCreate(['name' => $role]);
        }

        $permissions = Acl::permissions();
        $operations = Acl::operations();
        foreach ($permissions as $permission) {
            foreach ($operations as $operation) {

                $give_permission = true;
                if($operation !== Acl::OPERATION_R) {
                    $give_permission = !isset(config('print_permission')[$permission]) || config('print_permission')[$permission][$operation];
                }

                if($give_permission) {
                    \App\Models\Permission::query()
                        ->firstOrCreate([
                            'env' => $permission,
                            'name' => $operation.'_'.$permission
                        ]);
                }

            }
        }

        if($admin = Role::findByName(Acl::ROLE_ADMIN))
            $admin->givePermissionTo(Permission::all());

    }
}
