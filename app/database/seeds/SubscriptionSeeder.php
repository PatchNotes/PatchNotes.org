<?php

class SubscriptionSeeder extends Seeder {
    

    public function run() {
        $projects = Project::all();

        foreach($projects as $project) {
            // Number of subscribers
            $subs = rand(0,10);

            for($i = 0; $i < $subs; $i++) {
                // This should be fine since we're not generating a lot of users
                $user = User::all()->random(1);

                $project->subscribe($user);
            }

        }
    }

}