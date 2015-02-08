<?php namespace PatchNotes\Http\Controllers;

use PatchNotes\Models\User;

class UserController extends Controller
{

    public function getIndex()
    {
        abort(404);
    }

    public function getUser($username)
    {
        $user = User::where('username', $username)->first();

        if (!$user) {
            return abort(404);
        }

        return view('users/profile', compact('user'));
    }

}
