<?php

use App\OldProfileDrawingImage;
use Illuminate\Database\Seeder;

class OldProfileDrawingImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //<editor-fold desc="Characters">
        $character1 = OldProfileDrawingImage::create( [
            'name' => 'Fille',
            'type' => 'character',
            'filename' => '/img/personnages/fille.gif',
        ] );

        $character2 = OldProfileDrawingImage::create( [
            'name' => 'Adolescente',
            'type' => 'character',
            'filename' => '/img/personnages/adolescente.gif',
        ] );

        $character3 = OldProfileDrawingImage::create( [
            'name' => 'Garçon',
            'type' => 'character',
            'filename' => '/img/personnages/garcon.gif',
        ] );

        $character4 = OldProfileDrawingImage::create( [
            'name' => 'Adolescent',
            'type' => 'character',
            'filename' => '/img/personnages/adolescent.gif',
        ] );

        $character5 = OldProfileDrawingImage::create( [
            'name' => 'Aucun',
            'type' => 'character',
            'filename' => '/img/personnages/personnage.gif',
            'default' => true
        ] );
        //</editor-fold>

        //<editor-fold desc="Animals">
        $animal1 = OldProfileDrawingImage::create( [
            'name' => 'Chat',
            'type' => 'animal',
            'filename' => '/img/animaux/chat.gif',
        ] );

        $animal2 = OldProfileDrawingImage::create( [
            'name' => 'Souris',
            'type' => 'animal',
            'filename' => '/img/animaux/souris.gif',
        ] );

        $animal3 = OldProfileDrawingImage::create( [
            'name' => 'Fou',
            'type' => 'animal',
            'filename' => '/img/animaux/fou.gif',
        ] );

        $animal4 = OldProfileDrawingImage::create( [
            'name' => 'Chien',
            'type' => 'animal',
            'filename' => '/img/animaux/chien.gif',
        ] );

        $animal5 = OldProfileDrawingImage::create( [
            'name' => 'Aucun',
            'type' => 'animal',
            'filename' => '/img/animaux/animal.gif',
            'default' => true
        ] );
        //</editor-fold>

        //<editor-fold desc="Windows">
        $window1 = OldProfileDrawingImage::create( [
            'name' => 'Poisson',
            'type' => 'window',
            'filename' => '/img/hublots/poisson.gif',
        ] );

        $window2 = OldProfileDrawingImage::create( [
            'name' => 'Île',
            'type' => 'window',
            'filename' => '/img/hublots/ile.gif',
        ] );

        $window3 = OldProfileDrawingImage::create( [
            'name' => 'Saturne',
            'type' => 'window',
            'filename' => '/img/hublots/saturne.gif',
        ] );

        $window4 = OldProfileDrawingImage::create( [
            'name' => 'Lune',
            'type' => 'window',
            'filename' => '/img/hublots/lune.gif',
        ] );

        $window5 = OldProfileDrawingImage::create( [
            'name' => 'Main',
            'type' => 'window',
            'filename' => '/img/hublots/main.gif',
        ] );

        $window5 = OldProfileDrawingImage::create( [
            'name' => 'Tête',
            'type' => 'window',
            'filename' => '/img/hublots/tete.gif',
        ] );

        $window6 = OldProfileDrawingImage::create( [
            'name' => 'Fusée',
            'type' => 'window',
            'filename' => '/img/hublots/fusee.gif',
        ] );

        $window7 = OldProfileDrawingImage::create( [
            'name' => 'Gratte-ciel',
            'type' => 'window',
            'filename' => '/img/hublots/grateciels.gif',
        ] );

        $window8 = OldProfileDrawingImage::create( [
            'name' => 'Aucun',
            'type' => 'window',
            'filename' => '/img/hublots/hublot.gif',
            'default' => true
        ] );
        //</editor-fold>

        //<editor-fold desc="Paintings">
        $painting1 = OldProfileDrawingImage::create( [
            'name' => 'Chalet',
            'type' => 'painting',
            'filename' => '/img/tableaux/chalet.gif',
        ] );

        $painting2 = OldProfileDrawingImage::create( [
            'name' => 'Monstre',
            'type' => 'painting',
            'filename' => '/img/tableaux/monstre.gif',
        ] );

        $painting3 = OldProfileDrawingImage::create( [
            'name' => 'Auto',
            'type' => 'painting',
            'filename' => '/img/tableaux/auto.gif',
        ] );

        $painting4 = OldProfileDrawingImage::create( [
            'name' => 'Fleur',
            'type' => 'painting',
            'filename' => '/img/tableaux/fleur.gif',
        ] );

        $painting5 = OldProfileDrawingImage::create( [
            'name' => 'Ours',
            'type' => 'painting',
            'filename' => '/img/tableaux/ours.gif',
        ] );

        $painting6 = OldProfileDrawingImage::create( [
            'name' => 'Souris',
            'type' => 'painting',
            'filename' => '/img/tableaux/souris.gif',
        ] );

        $painting7 = OldProfileDrawingImage::create( [
            'name' => 'Aucun',
            'type' => 'painting',
            'filename' => '/img/tableaux/tableau.gif',
            'default' => true
        ] );
        //</editor-fold>
    }
}
