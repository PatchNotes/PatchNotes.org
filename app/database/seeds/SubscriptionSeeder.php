<?php

class SubscriptionSeeder extends Seeder {
	

	public function run() {
		$projects = Project::all();

		foreach($projects as $project) {
			// Number of subscribers
			$subs = rand(0,10);

			for($i = 0; $i < $subs; $i++) {
				$user = User::orderBy(DB::raw('RAND()'))->get()[0];

				$project->subscribe($user);
			}

		}
	}

}