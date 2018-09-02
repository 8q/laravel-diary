<?php

use Illuminate\Database\Seeder;

class DiariesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = App\User::find(1);
        factory(App\Diary::class, 5)->create([
            'user_id' => $user->id,
        ]);
    }
}
