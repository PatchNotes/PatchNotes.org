<?php

namespace Projects;

use Input;
use Project;
use Redirect;
use Sentry;
use Subscription;
use User;
use Response;
use Validator;

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
        if(!$success) {
            return Response::json(array('success' => false, 'error' => 'You\'re already subscribed to this project.'));
        }

        return Response::json(array('success' => true));
    }

    public function destroy() {

    }

} 