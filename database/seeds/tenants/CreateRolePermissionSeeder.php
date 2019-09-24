<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;
use Symfony\Component\Console\Output\ConsoleOutput;
use Hyn\Tenancy\Environment;

class CreateRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['create-enterprises',
                 'edit-enterprises',
                 'delete-enterprises',
                 'update-enterprises',
                 'add-enterprises',
                 'search-enterprises',
                 'create-records',
                 'edit-records',
                 'delete-records',
                 'update-records',
                 'add-records',
                 'search-records',
                 'create-users',
                 'edit-users',
                 'delete-users',
                 'update-users',
                 'add-users',
                ];

        foreach ($names as $name){
            if(Permission::where('name',$name)->get()->isEmpty()){
                Permission::create(['name' => $name]);                
            }
        }

        $role = Role::create(['name' => 'supervisor']);
        $role->givePermissionTo(['search-enterprises','search-records']);

        $role = Role::create(['name' => 'editor']);
        $role->givePermissionTo($names);

        $role = Role::create(['name' => 'Super Admin']);

    }
}
