<?php

use App\ScheduledEducationalActivity;
use Illuminate\Database\Seeder;

class SheduledEducationalActivitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $scheduledEducationalActivity1 = ScheduledEducationalActivity::create( [
            'name' => 'Classe de test 1',
            'teacher_id' => '1',
            'level_id' => '1',
            'canton_id' => '1'
        ] );

        $scheduledEducationalActivity2 = ScheduledEducationalActivity::create( [
            'name' => 'Classe de test 2',
            'teacher_id' => '2',
            'level_id' => '2',
            'canton_id' => '2'
        ] );

        $scheduledEducationalActivity3 = ScheduledEducationalActivity::create( [
            'name' => 'Classe de test 3',
            'teacher_id' => '1',
            'level_id' => '3',
            'canton_id' => '3'
        ] );
    }
}
