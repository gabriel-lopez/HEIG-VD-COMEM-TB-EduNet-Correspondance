<?php

use App\ScheduledEducationalActivityLevel;
use Illuminate\Database\Seeder;

class ScheduledEducationalActivityLevelsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $h1 = ScheduledEducationalActivityLevel::create( [
            'short_name' => '1H',
            'harmos_degree' => '1ère Harmos',
            'old_degree' => '1ère enfantine',
        ] );

        $h2 = ScheduledEducationalActivityLevel::create( [
            'short_name' => '2H',
            'harmos_degree' => '2ème Harmos',
            'old_degree' => '2ème enfantine',
        ] );

        $h3 = ScheduledEducationalActivityLevel::create( [
            'short_name' => '3H',
            'harmos_degree' => '3ème Harmos',
            'old_degree' => '1ère primaire',
        ] );

        $h4 = ScheduledEducationalActivityLevel::create( [
            'short_name' => '4H',
            'harmos_degree' => '4ème Harmos',
            'old_degree' => '2ème primaire',
        ] );

        $h5 = ScheduledEducationalActivityLevel::create( [
            'short_name' => '5H',
            'harmos_degree' => '5ème Harmos',
            'old_degree' => '3ème primaire',
        ] );

        $h6 = ScheduledEducationalActivityLevel::create( [
            'short_name' => '6H',
            'harmos_degree' => '6ème Harmos',
            'old_degree' => '4ème primaire',
        ] );

        $h7 = ScheduledEducationalActivityLevel::create( [
            'short_name' => '7H',
            'harmos_degree' => '7ème Harmos',
            'old_degree' => '5ème primaire',
        ] );

        $h8 = ScheduledEducationalActivityLevel::create( [
            'short_name' => '8H',
            'harmos_degree' => '8ème Harmos',
            'old_degree' => '6ème primaire',
        ] );

        $h9 = ScheduledEducationalActivityLevel::create( [
            'short_name' => '9H',
            'harmos_degree' => '9ème Harmos',
            'old_degree' => '1ère secondaire',
        ] );

        $h10 = ScheduledEducationalActivityLevel::create( [
            'short_name' => '10H',
            'harmos_degree' => '10ème Harmos',
            'old_degree' => '2ème secondaire',
        ] );

        $h11 = ScheduledEducationalActivityLevel::create( [
            'short_name' => '11H',
            'harmos_degree' => '11ème Harmos',
            'old_degree' => '3ème secondaire',
        ] );
    }
}