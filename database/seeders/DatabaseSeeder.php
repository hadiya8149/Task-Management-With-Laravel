<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory()
        //                 ->count(50)
        //                 ->create()
        //                 ->each(function ($user){
        //                     $user->assignRole('contributor');
        //                 });
        // $user = User::find(4);
        // $user->assignRole('manager');
        // $user->givePermissionTo(['create tasks', 'edit tasks', 'delete tasks', 'assign task', 'remove assignee', 'update assignee']);
    }
}
