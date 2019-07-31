<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Running APP Seeders');

        $this->call(CantonsSeeder::class);
        $this->call(ScheduledEducationalActivityLevelsSeeder::class);

        $this->call(OldProfileDrawingImagesSeeder::class);

        $this->call(AdministratorsTableSeeder::class);

        if(config('app.debug') == true) {
            $this->command->info('Running DEBUG/TEST Seeders');

            $this->call(TeachersTableSeeder::class);

            $this->call(SheduledEducationalActivitiesTableSeeder::class);

            $this->call(KeywordsTableSeeder::class);

            $this->call(StudentsTableSeeder::class);

            $this->command->info('Running DEBUG/TEST Factories');

            factory('App\Message', 22)->create();
        }
    }
}
