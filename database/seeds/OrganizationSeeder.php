<?php

use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder {

    private $faker;

    private $numOrgs = 25;

    public function __construct() {
        $this->faker = Faker\Factory::create();
        $this->faker->addProvider(new Faker\Provider\Company($this->faker));
        $this->faker->addProvider(new Faker\Provider\Internet($this->faker));
    }

    public function run() {

        for ($i = 0; $i < $this->numOrgs; $i++) {
            $f = $this->faker->unique();
            $companyName = $f->company;

            $org = new \PatchNotes\Models\Organization();
            $org->name = $companyName;
            $org->email = $f->email;
            $org->slug = str_slug($companyName);
            $org->site_url = $f->url;
            $org->description = $f->catchPhrase;
            $org->save();
        }
    }

}
