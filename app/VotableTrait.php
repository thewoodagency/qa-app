<?php
/**
 * Created by PhpStorm.
 * User: jay
 * Date: 10/10/18
 * Time: 3:15 PM
 */

namespace App;

trait VotableTrait
{
    public function votes()
    {
        return $this->morphToMany(User::class, 'votable');
    }

    public function upVotes()
    {
        return $this->votes()->wherePivot('vote', 1);
    }

    public function downVotes()
    {
        return $this->votes()->wherePivot('vote', -1);
    }
}