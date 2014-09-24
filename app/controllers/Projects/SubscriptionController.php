<?php

namespace Projects;

use Project;
use Redirect;
use Response;
use Sentry;
use User;

class SubscriptionController extends BaseController
{

    /**
     * @var User
     */
    private $user;

    public function __construct()
    {
        $this->beforeFilter(function () {
            if (!Sentry::check()) {
                return Response::json(array('success' => false, 'error' => 'Please login to subscribe to a project.'));
            }
        });

        $this->user = Sentry::getUser();
    }

    public function index()
    {
        Redirect::to('/');
    }

    public function store($participant, $project)
    {
        $owner = Project::resolveParticipant($participant);
        if (!$owner) {
            return Response::json(array('success' => false, 'error' => 'Participant not found.'));
        }

        $project = $owner->projects()->where('slug', $project)->first();
        if (!$project) {
            return Response::json(array('success' => false, 'error' => 'Project not found.'));
        }


        $success = $project->subscribe($this->user, $this->user->getDefaultLevels());
        if (!$success) {
            return Response::json(array('success' => false, 'error' => 'You\'re already subscribed to this project.'));
        }

        return Response::json(array('success' => true));
    }

    public function destroy($participant, $project)
    {
        $owner = Project::resolveParticipant($participant);
        if (!$owner) {
            return Response::json(array('success' => false, 'error' => 'Participant not found.'));
        }

        $project = $owner->projects()->where('slug', $project)->first();
        if (!$project) {
            return Response::json(array('success' => false, 'error' => 'Project not found.'));
        }


        $success = $project->unsubscribe($this->user);
        if (!$success) {
            return Response::json(array('success' => false, 'error' => 'You\'re not subscribed to this project.'));
        }

        return Response::json(array('success' => true));
    }

} 
