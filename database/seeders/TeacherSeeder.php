<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Teacher::create(['name' => 'Moshiur','email' => 'test@gmail.com','phone'=> '01770215536','description' => 'This is the First Test']);
        Teacher::create(['name' => 'Rony',   'email' => 'rony@gmail.com','phone'=> '01770215536','description' => 'This is the First Test']);
        Teacher::create(['name' => 'Rofiq',  'email' => 'test@gmail.com','phone'=> '01770215536','description' => 'This is the First Test']);
        Teacher::create(['name' => 'Manik',  'email' => 'manik@gmail.com','phone'=> '01770215536','description'=> 'This is the First Test']);
    }
}
