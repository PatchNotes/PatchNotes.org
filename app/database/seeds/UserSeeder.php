<?php

class UserSeeder extends Seeder {

	private $faker;

	private $numUsers = 50;

	public function __construct() {
		$this->faker = Faker\Factory::create();
	}

	public function run() {

		for ($i = 0; $i < $this->numUsers; $i++) {
			$username = $this->faker->userName;

			Sentry::createUser(array(
				'username' => $username,
				'password' => $username,
				'email' => $this->faker->email,
				'activated' => true
			));
		}
	}

} 
