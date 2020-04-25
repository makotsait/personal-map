<?php

use Illuminate\Database\Seeder;

use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(['user_name'=>'saito', 'email'=>'saito@gmail.com','password'=>bcrypt('EZLW77Tq755h')]);
        User::create(['user_name'=>'test1', 'email'=>'test@gmail.com','password'=>bcrypt('TM7uqGcdtVAu')]);
    }
}
