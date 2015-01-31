<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class SendUpdatesCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'patchnotes:updates-send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send out all updates';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire()
    {
        $level = NotificationLevel::where('key', $this->argument('notification_level'))->firstOrFail();

        $usersNeedingUpdates = DB::table('user_project_updates')->where('emailed_at', null)->where('notification_level_id', $level->id)->groupBy('user_id')->get(['user_id']);

        foreach($usersNeedingUpdates as $upu) {
            $user = User::find($upu->user_id)->firstOrFail();
            if( ! $this->rightTime($level, $user)) {
                continue;
            }

            $projectsUpdated = UserProjectUpdate::where('emailed_at', null)->where('notification_level_id', $level->id)->where('user_id', $user->id)->get()->groupBy('project_id');

            $title = $this->goodTitle($level, $user);

            // Do this in the background, we have a doublecheck in SendUpdates for emailed_at
            Mail::queue(
                ['emails.updates.grouped.html', 'emails.updates.grouped.text'],
                ['user' => $user, 'projectsUpdated' => $projectsUpdated],
            function($message) use ($user, $title) {
                $message->from(Config::get('patchnotes.emails.updates.from.address'), Config::get('patchnotes.emails.updates.from.name'));

                $message->to($user->email, $user->fullname)->subject($title);
            });
        }
    }

    private function goodTitle(NotificationLevel $level, $user) {
        switch($level->key) {
            case 'immediate':
                return "Immediate updates from ";

                break;
            case 'daily':
                $now = new DateTime('now', new DateTimeZone($user->preferences->timezone));
                return "Daily Digest for " . $now->format('F jS');

                break;
            case 'weekly':
                $now = new DateTime('now', new DateTimeZone($user->preferences->timezone));
                $plusOneWeek = new DateTime('now', new DateTimeZone($user->preferences->timezone));
                $plusOneWeek->add(new DateInterval("P7D"));
                return "Weekly Digest for " . $now->format('F jS') . " - " . $plusOneWeek->format('F jS');

                break;
        }
    }

    /**
     * Figure out if it's the right time for users update
     *
     * @param NotificationLevel $level
     * @param User $user
     * @return bool
     */
    private function rightTime(NotificationLevel $level, User $user) {
        // Currently in USER timezone
        $currently = new DateTime();
        $preferences = $user->preferences;
        switch($level->key) {
            case 'immediate':
                return true;

                break;
            case 'daily':
                if($currently->format('H:00:00') == $preferences->daily_time)
                    return true;

                break;
            case 'weekly':
                if($currently->format('l H:00:00') == ($preferences->weekly_day . " " . $preferences->weekly_time))
                    return true;

                break;
        }

        return false;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('notification_level', InputArgument::REQUIRED, 'Notification level we want to send for.')
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(

        );
    }

}
