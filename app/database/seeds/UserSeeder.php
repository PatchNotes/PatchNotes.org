<?php

class UserSeeder extends Seeder {

    private $numUsers = 100;

    public function run() {

        for($i = 0; $i < $this->numUsers; $i++) {
            $unique = Str::quickRandom(rand(5,20));

            Sentry::createUser(array(
                'username' => $unique,
                'password' => $unique,
                'email' => "$unique@localhost.localhost",
                'activated' => true
            ));
        }
    }

} 