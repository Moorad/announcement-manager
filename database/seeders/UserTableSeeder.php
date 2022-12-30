<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$test_user_1 = new User;
		$test_user_1->name = 'Bob';
		$test_user_1->email = 'bob@mail.com';
		$test_user_1->password = Hash::make('bob123456');
		$test_user_1->role = 'admin';
		$test_user_1->save();

		$test_user_1 = new User;
		$test_user_1->name = 'Michael';
		$test_user_1->email = 'mike@mail.com';
		$test_user_1->password = Hash::make('mike123456');
		$test_user_1->role = 'admin';
		$test_user_1->save();
	}
}
