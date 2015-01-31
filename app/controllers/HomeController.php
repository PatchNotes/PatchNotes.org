<?php

class HomeController extends BaseController {

    public function getIndex() {
        $newProjects = Project::orderBy('created_at', 'desc')->limit(4)->get();

        return View::make('home', array(
            'newProjects' => $newProjects
        ));
    }

    public function getUnsubscribe() {
        $rules = [
            'email' => 'required',
            'token' => 'required'
        ];
        $validator = Validator::make(Input::all(), $rules);
        if($validator->fails()) {
            return View::make('unsubscribe/error')->withErrors($validator);
        }

        $user = User::where('unsubscribe_token', Input::get('token'))->where('email', Input::get('email'))->firstOrFail();

        $user->unsubscribed_at = new DateTime();
        $user->save();

        return View::make('unsubscribe/success');
    }

    public function postUnsubscribeFeedback() {
        $rules = [
            'email' => 'required',
            'feedback' => 'required'
        ];
        $validator = Validator::make(Input::all(), $rules);
        if($validator->fails()) {
            return View::make('unsubscribe/feedback-error')->withErrors($validator);
        }
        $user = User::where('email', Input::get('email'))->firstOrFail();

        $fb = new UnsubscribeFeedback();
        $fb->user_id = $user->id;
        $fb->feedback = Input::get('feedback');
        $fb->save();

        return View::make('unsubscribe/feedback-success');
    }

} 
