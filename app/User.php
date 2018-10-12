<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $appends = ['url', 'avatar'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function getUrlAttribute()
    {
        return route("questions.show", $this->id);
    }

    public function getAvatarAttribute()
    {
        $email = $this->email;
        $size = 32;

        return "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email))) . "?s=" . $size;
    }

    public function favorites()
    {
        return $this->belongsToMany(Question::class, 'favorites')->withTimestamps(); //parameter user_id, question_id can be omitted

    }

    public function voteQuestions()
    {
        return $this->morphedByMany(Question::class, 'votable')->withTimestamps();
    }

    public function voteAQuestion(Question $question, $vote)
    {
        $this->_vote($this->voteQuestions(), $question, $vote);
    }

    public function voteAnswers()
    {
        return $this->morphedByMany(Answer::class, 'votable')->withTimestamps();
    }

    public function voteAAnswer(Answer $answer, $vote)
    {
        $this->_vote($this->voteAnswers(), $answer, $vote);
    }

    private function _vote($relationship, $model, $vote)
    {
        if ($relationship->where('votable_id', $model->id)->exists()) {
            $relationship->updateExistingPivot($model, ['vote' => $vote]);
        } else {
            $relationship->attach($model, ['vote' => $vote]);
        }

        $model->load('votes');
        $downVote = (int) $model->upVotes()->sum('vote');
        $upVote = (int) $model->downVotes()->sum('vote');
        $model->votes_count = $upVote + $downVote;
        $model->save();
    }
}
