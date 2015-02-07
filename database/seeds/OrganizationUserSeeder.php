<?php

use PatchNotes\Models\Organization;
use PatchNotes\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganizationUserSeeder extends Seeder {

    private $faker;

    public function __construct() {
        $this->faker = Faker\Factory::create();
    }

    public function run() {

        $orgs = Organization::all();

        foreach($orgs as $org) {
            $f = $this->faker->unique();
            
            $user = User::orderBy(DB::raw(DatabaseSeeder::getRandCommand()))->get()[0];
            $org->users()->attach($user, ['creator' => true]);

            $randUsers = rand(0,5);
            for ($i=0; $i < $randUsers; $i++) { 
                $user = User::orderBy(DB::raw(DatabaseSeeder::getRandCommand()))->get()[0];
                try {
                    $org->users()->attach($user);
                } catch(PDOException $e) {
                    continue;
                }

            }
        }
    }

}
