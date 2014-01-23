<?php

class ProjectSeeder extends Seeder {

	private $faker;

	public function __construct() {
		$this->faker = Faker\Factory::create();
	}


	public function run() {
		$users = User::all();

		for ($i = 0; $i < count($users); $i++) {
			$unique = $this->faker->domainWord;

			$project = Project::create(array(
				'name' => $unique,
				'slug' => Str::slug($unique),
				'description' => $unique,
				'site_url' => $this->faker->domainName
			));

			ProjectManager::create(array(
				'user_id' => $users[$i]->id,
				'project_id' => $project->id
			));
		}
	}

} 
