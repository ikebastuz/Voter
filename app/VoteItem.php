<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\User;


class VoteItem extends Model
{
    //
    use Notifiable;

    protected $table = 'voter_vote_items';

    public function svote(){
    	return $this->belongsTo('App\SVote', 's_vote_id', 'id');
    }

    public function choices(){
    	return $this->belongsToMany('App\User', 'voter_choices', 'vote_item_id');
    }

    public function countVotes(){
    	return $this->choices()->count();
    }

    public function deleteChoices(){
        $this->choices()->detach(User::all());
    }

}
