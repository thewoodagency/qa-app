<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Question;

class FavoritesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('favorites')->delete();

        $users = User::pluck('id')->all();

        foreach (Question::all() as $question)
        {
            for ($i = 0; $i < rand(1, count($users)); $i++)
            {
                //$users[$i]->favorites()->attach($question);
                $question->favorites()->attach($users[$i]);

            }
        }
    }
}
