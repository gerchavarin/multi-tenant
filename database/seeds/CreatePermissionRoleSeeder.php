<?php

use App\Role;
use App\Permission;
use Illuminate\Database\Seeder;

class CreatePermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create Permissions

        $permissions = [
            'create-enterprises',
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

        //Create Roles

        foreach ($permissions as $permission){
            if(Permission::where('name', $permission)->get()->isEmpty()){
                Permission::create(['name' => $permission]);                
            }
        }

        $roles = ['supervisor', 'editor'];

        foreach($roles as $role){
            if(Role::where('name', $role)->get()->isEmpty()){
                $role = Role::create(['name'=>$role]);
            }
        }

        //Assign permissions to roles

        $role = Role::find(1);
        $role->givePermissionTo(['search-records', 'search-enterprises']); 

        $role = Role::find(2);                                 
        $role->givePermissionTo([
            'search-records',
            'search-enterprises',
            'create-records',
            'edit-records',
            'update-records',
            'add-records'
        ]);
    }
}
