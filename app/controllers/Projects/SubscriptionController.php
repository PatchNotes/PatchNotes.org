<?php

namespace Projects;

use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        $this->beforeFilter('auth.json');

        $this->user = Sentry::getUser();
    }

    public function index()
    {
        Redirect::to('/');
    }

    public function store($participantSlug, $projectSlug)
    {
        try {
            list($owner, $project) = $this->resolveParticipantProject($participantSlug, $projectSlug);
        } catch(ModelNotFoundException $e) {
            return Response::json(['success' => false, 'error' => $e->getMessage()]);
        }

        $success = $project->subscribe($this->user, $this->user->getDefaultLevels());
        if (!$success) {
            return Response::json(array('success' => false, 'error' => 'You\'re already subscribed to this project.'));
        }

        return Response::json(array('success' => true));
    }

    public function unsubscribe($participantSlug, $projectSlug)
    {
        return $this->destroy($participantSlug, $projectSlug);
    }

    public function destroy($participantSlug, $projectSlug)
    {
        try {
            list($owner, $project) = $this->resolveParticipantProject($participantSlug, $projectSlug);
        } catch(ModelNotFoundException $e) {
            return Response::json(['success' => false, 'error' => $e->getMessage()]);
        }

        $success = $project->unsubscribe($this->user);
        if (!$success) {
            return Response::json(array('success' => false, 'error' => 'You\'re not subscribed to this project.'));
        }

        return Response::json(array('success' => true));
    }

} 
