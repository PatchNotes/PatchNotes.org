<?php

class UserController extends BaseController {

    public function getIndex() {
        App::abort(404);
    }

    public function getUser($username) {
        $user = User::where('username', $username)->first();

        if (!$user) {
            App::abort(404);
        }

        return View::make('users/profile', compact('user'));
    }

}
