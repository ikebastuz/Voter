<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Auth\VoteItem;

class User extends Authenticatable
{
    

    use Notifiable;
    
    protected $table = 'voter_users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function votes(){
        return $this->hasMany('App\Votes');
    }

    public function choices(){
        return $this->belongsToMany('App\VoteItem', 'voter_choices', 'user_id');
    }

    public function checkIfVoted($id){
        $user = User::find(auth()->user()->id);
        $s_vote_items = SVote::find($id)->item()->get(); // itemlist of passed vote
        $user_vote_list = $user->choices()->get(); // list of user choices
        $did = false;
        foreach($s_vote_items as $item){
            foreach($user_vote_list as $vote){
                if($item->id == $vote->id){
                    $did = true;
                }
            }
        }

        return $did;
    }
}
