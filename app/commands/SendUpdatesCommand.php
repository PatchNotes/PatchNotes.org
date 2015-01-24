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
    protected $name = 'patchnotes:updates.send';

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
        // Instead I'm going to hardcode the values for now.
        $sendTimes = [

        ];
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(

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
