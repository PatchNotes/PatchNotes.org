<?php

namespace Projects;

use Project;
use Redirect;
use Response;
use Sentry;
use User;

class SubscriptionController extends BaseController {

	/**
	 * @var User
	 */
	private $user;

	public function __construct() {
		$this->beforeFilter('auth');

		$this->user = Sentry::getUser();
	}

	public function index() {
		Redirect::to('/');
	}

	public function store($project) {
		$project = Project::where('slug', $project)->first();
		$success = $project->subscribe($this->user, $this->user->getDefaultLevels());
		if (!$success) {
			return Response::json(array('success' => false, 'error' => 'You\'re already subscribed to this project.'));
		}

		return Response::json(array('success' => true));
	}

	public function destroy($project) {
		$project = Project::where('slug', $project)->first();
		$success = $project->unsubscribe($this->user);
		if (!$success) {
			return Response::json(array('success' => false, 'error' => 'You\'re not subscribed to this project.'));
		}

		return Response::json(array('success' => true));
	}

} 
