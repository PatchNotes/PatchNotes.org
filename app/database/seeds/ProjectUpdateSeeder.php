<?php

class ProjectUpdateSeeder extends Seeder {

    private $faker;

    private $levels = array(10,50,100);

    public function __construct() {
        $this->faker = Faker\Factory::create();
    }

    public function run() {
        $projects = Project::all();

        foreach($projects as $project) {
            $updates = rand(0,10);

            for($i = 0; $i < $updates; $i++) {
                $faker = $this->faker->unique();
                $title = $faker->sentence();

                $update = ProjectUpdate::create(array(
                    'project_id' => $project->id,
                    'title' => $title,
                    'slug' => Str::slug($title),
                    'body' => implode("<br>", $faker->paragraphs()),
                    'level' => $this->levels[array_rand($this->levels)],
                    'user_id' => $project->managers()->first()->user_id
                ));

                Event::fire('project.update.create', array($project, $update));
            }
        }
    }

}