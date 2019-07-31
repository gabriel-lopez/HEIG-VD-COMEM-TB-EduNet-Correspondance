<?php

use App\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use App\Message;
use App\User;

class TeachersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teacher1 = Teacher::create( [
            'name' => 'Teacher 1',
            'surname' => 'Teacher 1 Surname',
            'email' => 'teacher1@teacher1.ch',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ] );

        $teacher2 = Teacher::create( [
            'name' => 'Teacher 2',
            'surname' => 'Teacher 2 Surname',
            'email' => 'teacher2@teacher2.ch',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ] );
    }
}
