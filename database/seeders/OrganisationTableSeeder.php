<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Organisation;
use App\Models\User;
use App\Models\UserOrganisation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganisationTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$org = new Organisation;
		$org->name = 'Mike\'s test organisation';
		$org->admin_id = 2;
		$org->save();

		$users = fake()->randomElements(User::whereNot('role', 'admin')->get(), 30);

		foreach ($users as $user) {
			$userOrg = new UserOrganisation;
			$userOrg->org_id = $org->id;
			$userOrg->user_id = $user->id;
			$userOrg->save();
		}

		$usersWithAnnouncements = fake()->randomElements($users, 10);

		foreach ($usersWithAnnouncements as $user) {
			User::find($user->id)->update(['role' => 'announcer']);
			Announcement::factory(fake()->numberBetween(1, 4))->create([
				'user_id' => $user->id,
				'org_id' => $org->id
			]);
		}
	}
}
