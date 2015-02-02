<?php
namespace PatchNotes\Events;

use Mail;

class UserEvents {

    public function onRegister($data, $activationCode) {
        if(!is_null($data->unsubscribed_at)) {
            return;
        }
        Mail::send('emails/html/auth/register', array('user' => $data, 'activationCode' => $activationCode), function ($m) use ($data) {
            $m->to($data->email)->subject('Welcome to PatchNotes!');
        });
    }

    public function onForgot($data, $forgotCode) {
        if(!is_null($data->unsubscribed_at)) {
            return;
        }
        Mail::send('emails/html/auth/forgot', array('user' => $data, 'forgotCode' => $forgotCode), function ($m) use ($data) {
                $m->to($data->email)->subject('Forgot Password?');
            }
        );
    }

    public function subscribe($events) {
        $events->listen('user.register', 'PatchNotes\Events\UserEvents@onRegister');
        $events->listen('user.forgot', 'PatchNotes\Events\UserEvents@onForgot');
    }

}
