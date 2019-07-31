<?php

use App\Canton;
use Illuminate\Database\Seeder;

class CantonsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $zh = Canton::create( [
            'name' => 'Zürich',
            'code' => 'ZH',
        ] );

        $be = Canton::create( [
            'name' => 'Bern',
            'code' => 'BE',
        ] );

        $lu = Canton::create( [
            'name' => 'Luzern',
            'code' => 'LU',
        ] );

        $ur = Canton::create( [
            'name' => 'Uri',
            'code' => 'UR',
        ] );

        $sz = Canton::create( [
            'name' => 'Schwyz',
            'code' => 'SZ',
        ] );

        $be = Canton::create( [
            'name' => 'Obwalden',
            'code' => 'OW',
        ] );

        $nw = Canton::create( [
            'name' => 'Nidwalden',
            'code' => 'NW',
        ] );

        $gl = Canton::create( [
            'name' => 'Glarus',
            'code' => 'GL',
        ] );

        $zg = Canton::create( [
            'name' => 'Zug',
            'code' => 'ZG',
        ] );

        $fr = Canton::create( [
            'name' => 'Fribourg',
            'code' => 'FR',
        ] );

        $so = Canton::create( [
            'name' => 'Solothurn',
            'code' => 'SO',
        ] );

        $bs = Canton::create( [
            'name' => 'Basel-Stadt ',
            'code' => 'BS',
        ] );

        $bl = Canton::create( [
            'name' => 'Basel-Landschaft ',
            'code' => 'BL',
        ] );

        $sh = Canton::create( [
            'name' => 'Schaffhausen',
            'code' => 'SH',
        ] );

        $ar = Canton::create( [
            'name' => 'Appenzell Ausserrhoden',
            'code' => 'AR',
        ] );

        $ai = Canton::create( [
            'name' => 'Appenzell Innerrhoden',
            'code' => 'AI',
        ] );

        $sg = Canton::create( [
            'name' => 'St. Gallen',
            'code' => 'SG',
        ] );

        $gr = Canton::create( [
            'name' => 'Grisons',
            'code' => 'GR',
        ] );

        $ag = Canton::create( [
            'name' => 'Aargau',
            'code' => 'AG',
        ] );

        $tg = Canton::create( [
            'name' => 'Thurgau',
            'code' => 'TG',
        ] );

        $ti = Canton::create( [
            'name' => 'Ticino',
            'code' => 'TI',
        ] );

        $vd = Canton::create( [
            'name' => 'Vaud',
            'code' => 'VD',
        ] );

        $vs = Canton::create( [
            'name' => 'Valais',
            'code' => 'VS',
        ] );

        $ne = Canton::create( [
            'name' => 'Neuchâtel',
            'code' => 'NE',
        ] );

        $ge = Canton::create( [
            'name' => 'Geneva',
            'code' => 'GE',
        ] );

        $ju = Canton::create( [
            'name' => 'Jura',
            'code' => 'JU',
        ] );
    }
}
