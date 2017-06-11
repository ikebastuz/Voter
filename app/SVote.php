<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SVote extends Model
{
    //
    use Notifiable;

    protected $table = 'voter_s_votes';

    public function vote(){
    	return $this->belongsTo('App\Votes', 'vote_id', 'id');
    }

    public function item(){
    	return $this->HasMany('App\VoteItem', 's_vote_id', 'id');
    }

    public function countVotedUsers(){
        $items = $this->item()->get();

        $votedUsersList = array();
        foreach($items as $item){
            $votedUsers = $item->choices()->get();
            foreach ($votedUsers as $user) {
                if(!in_array($user->id, $votedUsersList)){
                    $votedUsersList[] = $user->id;
                }
            }
        }
        return count($votedUsersList);
    }

    public function stats(){
    	$items = $this->item()->get();
    	$t_stats = array();

    	if($this->type != 2){
            $total = 0;
            foreach($items as $item){
                $itemvotes = $item->choices()->get()->count();
                $t_stats[] = $itemvotes;
                $total += $itemvotes;
            }
            if($total != 0){
                foreach($t_stats as $k=>$v){
                    $t_stats[$k] = round($v / $total * 100, 0);
                }
            }
        }else{
            $votedUsers = $this->countVotedUsers();
            foreach($items as $item){
                $itemvotes = $item->choices()->get()->count();
                $t_stats[] = round($itemvotes / $votedUsers * 100 , 0);
            }
            return $t_stats;
        }
        
    	
    	return $t_stats;

    }

}
