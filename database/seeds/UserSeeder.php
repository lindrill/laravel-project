<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$user = new User();
    	$user->name = 'Administrator';
    	$user->email = 'admin@gmail.com';
    	$user->password = Hash::make('admin123');
    	$user->save();

    	$role = new Role();
    	$role->name = 'admin';
    	$role->user_id = $user->id;
    	$role->save();

    }
}
