<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$tags = ["Administration", "Operation", "Research", "Development", "Sales", "Human resources", "Customer service", "Finance", "Legal", "Engineering", "Production"];
		foreach ($tags as $t) {
			$tag = new Tag;
			$tag->name = $t;
			$tag->save();
		}
	}
}
