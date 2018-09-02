<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class)->create([
            'email' =>env('TEST_USER_EMAIL', 'test1@hoge.fuga'),
            'password' => Hash::make(env('TEST_USER_PASSWORD', 'secret')),
        ]);
    }
}
