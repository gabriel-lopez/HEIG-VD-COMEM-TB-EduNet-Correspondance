<?php

use App\Administrator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdministratorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Administrator::create( [
            'name' => 'Claude',
            'surname' => 'Burdet',
            'email' => 'admin@admin.ch',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ] );
    }
}
