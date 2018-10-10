<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Question;
use App\Answer;

class VotableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('votables')->where('votable_type', 'App\Question')->delete();
        \DB::table('votables')->where('votable_type', 'App\Answer')->delete();

        $users = User::all();
        $votes = [-1, 1];

        foreach (Question::all() as $question)
        {
            for ($i = 0; $i < rand(1, $users->count()); $i++)
            {
                $users[$i]->voteAQuestion($question, $votes[rand(0,1)]);
            }
        }

        foreach (Answer::all() as $answer)
        {
            for ($i = 0; $i < rand(1, $users->count()); $i++)
            {
                $users[$i]->voteAAnswer($answer, $votes[rand(0,1)]);
            }
        }
    }
}
