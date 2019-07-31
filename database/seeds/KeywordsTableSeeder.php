<?php

use App\Administrator;
use App\Keyword;
use Illuminate\Database\Seeder;

class KeywordsTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $keyword1 = Keyword::make( [
            'text' => 'Football',
            'text_normalized' => 'football',
        ] );

        $keyword1->creator()->associate(Administrator::find(1));

        $keyword1->save();

        $keyword2 = Keyword::make( [
            'text' => 'Tennis',
            'text_normalized' => 'tennis',
        ] );

        $keyword2->creator()->associate(Administrator::find(1));

        $keyword2->save();

        $keyword3 = Keyword::make( [
            'text' => 'Dance',
            'text_normalized' => 'dance',
        ] );

        $keyword3->creator()->associate(Administrator::find(1));

        $keyword3->save();
    }
}
