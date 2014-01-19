<?php

class ProjectSeeder extends Seeder {

    public function run() {
        $users = User::all();

        for($i = 0; $i < count($users); $i++) {
            $unique = Str::quickRandom(rand(4,20));

            $project = Project::create(array(
                'name' => $unique,
                'slug' => Str::slug($unique),
                'description' => $unique,
                'site_url' => "http://$unique.localhost"
            ));

            ProjectManager::create(array(
                'user_id' => $users[$i]->id,
                'project_id' => $project->id
            ));
        }
    }

} 