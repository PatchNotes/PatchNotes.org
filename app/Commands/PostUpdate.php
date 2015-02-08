<?php namespace PatchNotes\Commands;

use PatchNotes\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;
use PatchNotes\Models\Project;
use PatchNotes\Models\Subscription;
use PatchNotes\Models\ProjectUpdate;
use PatchNotes\Models\UserProjectUpdate;

class PostUpdate extends Command implements SelfHandling {
	/**
	 * @var ProjectUpdate
	 */
	private $update;
	/**
	 * @var Project
	 */
	private $project;

	/**
	 * Create a new command instance.
	 *
	 * @param Project $project
	 * @param ProjectUpdate $update
	 */
	public function __construct(Project $project, ProjectUpdate $update)
	{
		$this->update = $update;
		$this->project = $project;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		// Get all users of the project
		$subs = Subscription::where('project_id', $this->project->id)->where('project_update_level_id', $this->update->project_update_level_id)->get();
		foreach($subs as $sub) {
			$userProjectUpdate = new UserProjectUpdate();
			$userProjectUpdate->user_id = $sub->user_id;
			$userProjectUpdate->project_id = $this->project->id;
			$userProjectUpdate->project_update_id = $this->update->id;
			$userProjectUpdate->project_update_level_id = $sub->project_update_level_id;
			$userProjectUpdate->notification_level_id = $sub->notification_level_id;
			$userProjectUpdate->save();
		}
	}

}
