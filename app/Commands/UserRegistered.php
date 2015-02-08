<?php namespace PatchNotes\Commands;

use Mail;
use PatchNotes\Commands\Command;

use Illuminate\Contracts\Bus\SelfHandling;
use PatchNotes\Models\User;

class UserRegistered extends Command implements SelfHandling
{

    protected $user;

    /**
     * Create a new command instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
        if (!is_null($this->user->unsubscribed_at)) {
            return;
        }

        $user = $this->user;

        Mail::send('emails/html/auth/register', array('user' => $user, 'activationCode' => $user->getActivationCode()), function ($m) use ($user) {
            $m->to($user->email)->subject('Welcome to PatchNotes!');
        });
    }

}
