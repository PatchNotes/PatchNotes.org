<?php

class UserSeeder extends Seeder {

    private $faker;

    const numUsers = 25;

    public function __construct() {
        $this->faker = Faker\Factory::create();
        $this->faker->addProvider(new Faker\Provider\Internet($this->faker));
    }

    public function run() {

        for ($i = 0; $i < self::numUsers; $i++) {
            $username = $this->faker->unique()->username;

            Sentry::createUser(array(
                'username' => $username,
                'password' => $username,
                'email' => $this->faker->unique()->email,
                'activated' => true
            ));
        }
    }

}
