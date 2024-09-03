<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        // creaet permissions
        Permission::create(['name'=>'create tasks']);
        Permission::create(['name'=>'edit tasks']);
        Permission::create(['name'=>'delete tasks']);
        Permission::create(['name'=>'update assigned task']);
        Permission::create(['name'=>'assign task']);
        Permission::create(['name'=>'remove assignee']);
        Permission::create(['name'=>'update assignee']);


        // create roles and assign created permissions
        $role = Role::create(['name'=>'manager'])->givePermissionTo(['create tasks', 'edit tasks', 'delete tasks', 'assign task', 'remove assignee', 'update assignee']);

        $role = Role::create(['name'=>'contributor'])->givePermissionTo('update assigned task');
        
        $role = Role::create(['name'=>'super-admin'])->givePermissionTo(Permission::all());


    }
}
