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

        // This will need to look at the current time and then pull updates that should be going out.
        // Instead I'm going to hard code the values for now.
        $times = [
            0 => '',
            24  => '19', // Daily
            168 => 'Sunday 19' // Weekly
        ];

        $data = [];

        $notificationLevels = NotificationLevel::where('level', $this->argument('notification_level'))->get();
        foreach($notificationLevels as $level) {

            $userUpdates = UserProjectUpdate::where('emailed_at', null)->where('notification_level_id', $level->id)->get();

            /** @var UserProjectUpdate $up */
            foreach($userUpdates as $up) {
                if( ! $this->rightTime($level, $times[$level->level])) {
                    continue;
                }

                $up->emailed_at = new \DateTime();
                //$up->save();

                $data[] = [
                    $level->name,
                    $up->project_update->project->name,
                    $up->project_update->title,
                    $up->user->username
                ];
            }

        }

        $this->table(
            ['NLevel', 'Project', 'Update', 'User'],
            $data
        );
    }

    private function rightTime(NotificationLevel $level, $time) {
        // Currently in USER timezone
        $currently = new DateTime();
        switch($level->level) {
            // Immediate
            case 0:
                return true;

                break;
            // Daily format is '22'
            case 24:
                if($currently->format('H:00:00') == $time)
                    return true;

                break;
            // Weekly format is Sunday 22
            case 168:
                if($currently->format('l H') == $time)
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
