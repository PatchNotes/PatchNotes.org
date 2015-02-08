<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Event;
use PatchNotes\Commands\PostUpdate;
use PatchNotes\Models\Organization;
use PatchNotes\Models\Project;
use PatchNotes\Models\ProjectUpdate;

class ProjectUpdateSeeder extends Seeder {

    private $faker;

    private $levels = array(1,2,3);
    /**
     * @var \Illuminate\Contracts\Bus\Dispatcher
     */
    private $bus;

    public function __construct(\Illuminate\Contracts\Bus\Dispatcher $bus) {
        $this->faker = Faker\Factory::create();
        $this->bus = $bus;
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
                    'slug' => str_slug($title),
                    'body' => implode("<br>", $faker->paragraphs()),
                    'project_update_level_id' => $this->levels[array_rand($this->levels)],
                    'user_id' => $owner->id
                ));

                $this->bus->dispatch(
                    new PostUpdate($project, $update)
                );

            }
        }
    }

}