<?php

class ProjectSeeder extends Seeder {

	private $faker;

	public function __construct() {
		$this->faker = Faker\Factory::create();
	}

	public function run() {
		$users = User::all();

		foreach($users as $user) {
			$faker = $this->faker->unique();
			$unique = $faker->domainWord;

			$project = Project::create(array(
				'name' => $unique,
				'slug' => Str::slug($unique),
				'description' => $faker->sentence(),
				'site_url' => $faker->url
			));

			ProjectManager::create(array(
				'user_id' => $user->id,
				'project_id' => $project->id
			));
		}
	}

}
