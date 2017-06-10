<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Votes;
use App\SVote;
use App\VoteItem;
use App\User;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function dashboard(){
        $votes = auth()->user()->votes()->orderBy('created_at','desc')->get();
        return view('dashboard')->with('votes', $votes);
    }

    public function voteList(){
        $votes = Votes::orderBy('created_at','desc')->get();
        return view('dashboard')->with('votes', $votes);
    }


    public function viewVote($id){
        $user = auth()->user();
        $vote = Votes::find($id);
        $svote = $vote->s_vote()->get();
        $itemlist = array();
        $voted = array();
        $stats = array();
        foreach($svote as $k=>$v){
            if($user->checkIfVoted($svote[$k]->id)){
                $voted[$k] = true;
            }
            $stats[$k] = $svote[$k]->stats();
            $items = $svote[$k]->item()->get();
            $itemlist[$k] = $items;
        }
        $norevote = false;
        return view('vote', ['vote' => $vote, 'svote' => $svote, 'items' => $itemlist, 'voted' => $voted, 'stats' => $stats, 'norevote' => $norevote]);   
    }

    public function viewStatsVote($id){
        $user = auth()->user();
        $vote = Votes::find($id);
        $svote = $vote->s_vote()->get();
        $itemlist = array();
        $voted = array();
        $norevote = array();
        foreach($svote as $k=>$v){
            if($user->checkIfVoted($svote[$k]->id)){
                $norevote[$k] = false;
            }else{
                $norevote[$k] = true;
            }
            $voted[$k] = true;
            $stats[$k] = $svote[$k]->stats();
            $items = $svote[$k]->item()->get();
            $itemlist[$k] = $items;
        }
        return view('vote', ['vote' => $vote, 'svote' => $svote, 'items' => $itemlist, 'voted' => $voted, 'stats' => $stats, 'norevote' => $norevote]);
    
    }
}
