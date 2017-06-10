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

    public function stats(){
    	$items = $this->item()->get();
    	$t_stats = array();
    	$total = 0;
    	foreach($items as $item){
    		$itemvotes = $item->choices()->get()->count();
    		$t_stats[] = $itemvotes;
    		$total += $itemvotes;
    	}
    	$stats = array();
    	if($total != 0){
    		foreach($t_stats as $k=>$v){
    			$stats[] = round($v / $total * 100, 0);
    		}
    	}
    	
    	return $stats;

    }

}
