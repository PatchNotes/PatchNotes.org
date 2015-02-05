<?php namespace PatchNotes\Http\Controllers;

use PatchNotes\Models\Project;

class HomeController extends Controller {

    public function getIndex(Project $project) {
        $newProjects = $project->orderBy('created_at', 'desc')->limit(4)->get();

        return view('home', [
            'newProjects' => $newProjects
        ]);
    }

    public function getUnsubscribe() {
        $rules = [
            'email' => 'required',
            'token' => 'required'
        ];
        $validator = Validator::make(Input::all(), $rules);
        if($validator->fails()) {
            return view('unsubscribe/error')->withErrors($validator);
        }

        $user = User::where('unsubscribe_token', Input::get('token'))->where('email', Input::get('email'))->firstOrFail();

        $user->unsubscribed_at = new DateTime();
        $user->save();

        return view('unsubscribe/success');
    }

    public function postUnsubscribeFeedback() {
        $rules = [
            'email' => 'required',
            'feedback' => 'required'
        ];
        $validator = Validator::make(Input::all(), $rules);
        if($validator->fails()) {
            return view('unsubscribe/feedback-error')->withErrors($validator);
        }
        $user = User::where('email', Input::get('email'))->firstOrFail();

        $fb = new UnsubscribeFeedback();
        $fb->user_id = $user->id;
        $fb->feedback = Input::get('feedback');
        $fb->save();

        return view('unsubscribe/feedback-success');
    }

} 
