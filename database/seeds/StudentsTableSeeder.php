<?php

use App\Keyword;
use App\OldProfileDrawing;
use App\Student;
use Illuminate\Database\Seeder;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $student1 = Student::create( [
            'login' => 'test1@test1.ch',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'name' => 'Student 1 Name',
            'surname' => 'Student 1 Surname',
            'sex' => 'male',
            'birthdate' => '2000-07-05',
            'description' => 'blah blah',
            'scheduled_educational_activity_id' => '1'
        ] );

        $student1OldProfileDrawing = OldProfileDrawing::createOne();

        $student1->keywords()->save(Keyword::find(1));
        $student1->oldProfileDrawing()->save($student1OldProfileDrawing);

        $student2 = Student::create( [
            'login' => 'test2@test2.ch',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'name' => 'Student 2 Name',
            'surname' => 'Student 2 Surname',
            'sex' => 'female',
            'birthdate' => '1999-07-05',
            'description' => 'blah blah',
            'scheduled_educational_activity_id' => '1'
        ] );

        $student2OldProfileDrawing = OldProfileDrawing::createOne();

        $student2->keywords()->save(Keyword::find(2));
        $student2->oldProfileDrawing()->save($student2OldProfileDrawing);

        $student3 = Student::create( [
            'login' => 'test3@test3.ch',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'name' => 'Student 3 Name',
            'surname' => 'Student 3 Surname',
            'sex' => 'female',
            'birthdate' => '2003-07-05',
            'description' => 'blah blah',
            'scheduled_educational_activity_id' => '2'
        ] );

        $student3OldProfileDrawing = OldProfileDrawing::createOne();

        $student3->oldProfileDrawing()->save($student3OldProfileDrawing);


        $student4 = Student::create( [
            'login' => 'test4@test4.ch',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'name' => 'Student 4 Name',
            'surname' => 'Student 4 Surname',
            'sex' => 'female',
            'birthdate' => '2003-07-05',
            'description' => 'blah blah',
            'scheduled_educational_activity_id' => '1'
        ] );

        $student4OldProfileDrawing = OldProfileDrawing::createOne();

        $student4->oldProfileDrawing()->save($student4OldProfileDrawing);



        $student1->correspondents()->attach($student2);
        $student2->correspondents()->attach($student1);

        $student1->correspondents()->attach($student3);
        $student3->correspondents()->attach($student1);
    }
}
