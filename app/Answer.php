<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getBodyHtmlAttribute()
    {
        return \Parsedown::instance()->text($this->body);
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public static function boot()
    {
        parent::boot();

        //created event called whenever answer is created
        static::created(function ($answer){
            $answer->question->increment('answers_count'); //increment() method call save() behind the scenes
        });
    }
}


// $q = App\Question::first(); //return first question
// $q->answers()->save(factory(App\Answer::class)->make());