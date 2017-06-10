<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Votes extends Model
{
	use Notifiable;
    
    protected $table = 'voter_votes';

    public function user(){
    	return $this->belongsTo('App\User');
    }

    public function s_vote(){
    	return $this->HasMany('App\SVote','vote_id');
    }
}
