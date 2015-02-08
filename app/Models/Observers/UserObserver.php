<?php namespace PatchNotes\Models\Observers;


use PatchNotes\Models\Organization;
use PatchNotes\Models\UserPreference;

class UserObserver
{

    public function creating($user)
    {
        $org = Organization::where('slug', $user->slug)->first();

        if ($org) {
            return false;
        }

        $user->unsubscribe_token = str_random(42);

        return true;
    }

    public function created($user)
    {
        if (empty($user->preferences)) {
            $preference = new UserPreference();

            $user->preferences()->save($preference);
        }
    }

    public function updating($user)
    {
        $org = Organization::where('slug', $user->slug)->first();

        if ($org) {
            return false;
        }
    }
}