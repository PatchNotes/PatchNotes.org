<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Model::unguard();

        $this->call('UserSeeder');
        $this->call('OrganizationSeeder');
        $this->call('OrganizationUserSeeder');
        $this->call('ProjectSeeder');
        $this->call('SubscriptionSeeder');
        $this->call('ProjectUpdateSeeder');
    }

    public static function getRandCommand() {
        $databaseEngine = Config::get('database.default');
        $driver = Config::get("database.connections.". $databaseEngine .".driver");

        switch ($driver) {
            case 'pgsql':
                return "RANDOM()";
                break;
            case 'mysql':
                return "RAND()";
                break;
            
            default:
                return "RAND()";
                break;
        }
    }

}
