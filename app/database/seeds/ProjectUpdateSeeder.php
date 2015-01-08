<?php

class ProjectUpdateSeeder extends Seeder {

    private $faker;

    private $levels = array(1,2,3);

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

                $owner = $project->owner;
                if($owner instanceof Organization) {
                    $owner = $owner->creator();
                }

                $update = ProjectUpdate::create(array(
                    'project_id' => $project->id,
                    'title' => $title,
                    'slug' => Str::slug($title),
                    'body' => implode("<br>", $faker->paragraphs()),
                    'project_update_level_id' => $this->levels[array_rand($this->levels)],
                    'user_id' => $owner->id
                ));

                Event::fire('project.update.create', array($project, $update));
            }
        }
    }

}