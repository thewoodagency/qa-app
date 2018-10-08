<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Answer;
use App\Policies\AnswerPolicy;

class AcceptAnswerController extends Controller
{
    public function accept(Answer $answer)
    {
        $this->authorize('accept', $answer); // accept policy in AnswerPolicy
        $answer->question->acceptBestAnswer($answer);
        return back();
    }
}
