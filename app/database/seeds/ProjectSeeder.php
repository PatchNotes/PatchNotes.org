<?php

class ProjectSeeder extends Seeder {

    private $faker;

    public function __construct() {
        $this->faker = Faker\Factory::create();
    }

    public function run() {
        $participants = $this->getSomeParticipants(UserSeeder::numUsers / 2);

        foreach($participants as $owner) {
            $faker = $this->faker->unique();
            $unique = $faker->domainWord;

            $project = new Project;
            $project->name = ucwords($unique);
            $project->slug = Str::slug($unique);
            $project->description = $faker->sentence();
            $project->site_url = $faker->url;

            $owner->projects()->save($project);
        }
    }
    private function getSomeParticipants($numParticipants) {
        $participants = [];

        for ($i=0; $i < $numParticipants; $i++) {
            $rand = rand(0,1);

            if($rand == 0) {
                $participants[] = User::orderBy(DB::raw(DatabaseSeeder::getRandCommand()))->get()[0];
            } else {
                $participants[] = Organization::orderBy(DB::raw(DatabaseSeeder::getRandCommand()))->get()[0];
            }
        }

        return $participants;
    }

}
