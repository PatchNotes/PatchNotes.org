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
        $input = Input::all();

        $rules = array(
            'subscription_level' => 'required',
            'notification_level' => 'required'
        );
        $validator = Validator::make($input, $rules);
        if($validator->fails()) {
            return Response::json(array('success' => false, 'error' => 'Somehow you\'re missing input data, find a stable connection and try again.'));
        }

        $project = Project::where('slug', $project)->first();

        $subscription = new Subscription();

        $subscription->user_id = $this->user->id;
        $subscription->project_id = $project->id;
        $subscription->subscription_level = $input['subscription_level'];
        $subscription->notification_level = $input['notification_level'];

        $success = $subscription->save();
        if(!$success) {
            return Response::json(array('success' => false, 'error' => 'Somehow saving your subscription failed.'));
        }

        return Response::json(array('success' => true));
    }

    public function destroy() {

    }

} 