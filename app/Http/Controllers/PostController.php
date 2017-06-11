<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Votes;
use App\SVote;
use App\VoteItem;
use App\User;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    
    public function createVote(){
    	if(!Auth::check()){
        	return redirect('/')->with('alert-message', 'Unauthorized page');
        }

        return view('createvote');
    }

    public function postCreateVote(Request $request){

        $this->validate($request, [
            'vote_title' => 'required|max:120'
        ]);

        /* Saving main vote */
        $vote = new Votes();
        $vote->title = $request['vote_title'];
        $vote->description = is_null($request['vote_desc']) ? '' : $request['vote_desc'];
        $vote->user_id = auth()->user()->id;
        $vote->save();
        $voteInsertedId = $vote->id;

        $qcount = $request['qcount']; // question count

        /* Saving inner votes */
        for($i=1; $i<=$qcount; $i++){

            if(isset($request['question_title'.$i])){

                $this->validate($request, [
                    'question_title'.$i => 'required|max:120'
                ]);

                $svote = new SVote();
                $svote->title = $request['question_title'.$i];
                $svote->description = is_null($request['question_help_text'.$i]) ? '' : $request['question_help_text'.$i];
                $svote->active = 1;
                $svote->vote_id = $voteInsertedId;
                $svote->type = $request['question_type'.$i];
                $svote->save();
                $sVoteInsertedId = $svote->id;

                /* Saving vote options */
                if($svote->type != 3){
                    foreach($request['option'.$i] as $k=>$v){
                        if(is_null($v))continue;
                        $item = new VoteItem();
                        $item->title = $v;
                        $item->s_vote_id = $sVoteInsertedId;
                        $item->save();
                    }
                }
            }
        }
        if($request['jump'] == 1){
            return redirect('/vote/'.$voteInsertedId)->with('success-message', 'Vote created successfully');
        }else{
            return redirect('/dashboard')->with('success-message', 'Vote created successfully');
        }
    }

    

    public function activate($id){

        $user_id = auth()->user()->id;
        $svote = SVote::find($id);

        if($user_id == $svote->vote()->first()->user()->first()->id){       
            $svote->active = $svote->active==1 ? 0 : 1;
            $svote->update();

            return redirect()->back();          
        }else{
            return redirect('/dashboard')->with('alert-message', 'Unauthorized page');
        }
        
    }

    public function editVote($id){

        $user_id = auth()->user()->id;
        $svote = SVote::find($id);

        if($user_id == $svote->vote()->first()->user()->first()->id){       
            $itemlist = $svote->item()->orderBy('id')->get();        
            return view('edit', ['svote' => $svote, 'items' => $itemlist, 'voteid' => $svote->vote()->first()->id]);            
        }else{
            return redirect('/dashboard')->with('alert-message', 'Unauthorized page');
        }
        
    }

    public function updateVote($id, Request $request){
        $user = auth()->user();
        $svote = SVote::find($id);

        if($user->id == $svote->vote()->first()->user()->first()->id){
            $this->validate($request, [
                'question_title' => 'required|max:120'
            ]);

            $svote->title = $request['question_title'];
            $svote->description = is_null($request['question_help_text']) ? '' : $request['question_help_text'];
            $svote->type = $request['question_type'];
            $svote->update();

            $items = $svote->item()->orderBy('id')->get();

            if($request['question_type'] != 3){
            	/* Checking if any items were removed */
	            foreach($items as $item){
	                $exists = false;
	                foreach($request['option'] as $k=>$v){
	                    if($item->title == $v){
	                        $exists = true;
	                    }
	                }
	                if(!$exists){
	                    /* Deleting all connected choices */
	                    $item->deleteChoices();
	                    /* Deleting item */
	                    $item->delete();
	                }
	            }

	            /* Checking if any items were added */
	            foreach($request['option'] as $k=>$v){
	                $item = VoteItem::where([['s_vote_id', '=', $svote->id], ['title', '=', $v]])->first();
	                if(!$item){
	                    if(is_null($v))continue;
	                    $item = new VoteItem();
	                    $item->title = $v;
	                    $item->s_vote_id = $svote->id;
	                    $item->save();
	                }
	            }
            }else{
            	/* If question type is text-input - remove all options */
            	foreach($items as $item){
                    $item->deleteChoices();
                    $item->delete();
            	}
            }
            

            return redirect('/vote/'.$svote->vote()->first()->id)->with('success-message', 'Vote updated successfully');            
        }else{
            return redirect('/dashboard')->with('alert-message', 'Unauthorized page');
        }
        
    }


    public function renameVote($id){
        $user_id = auth()->user()->id;
        $vote = Votes::find($id);
                
        if($user_id == $vote->user_id){
            return view('rename', ['vote' => $vote]);            
        }else{
            return redirect('/dashboard')->with('alert-message', 'Unauthorized page');
        }
        
    }

    public function postRenameVote($id, Request $request){
        $user_id = auth()->user()->id;
        $vote = Votes::find($id);
        
        if($user_id == $vote->user_id){
            $this->validate($request, [
                'vote_title' => 'required|max:120'
            ]);
            
            $vote->title = $request['vote_title'];
            $vote->description = is_null($request['vote_desc']) ? '' : $request['vote_desc'];
            $vote->update();

            return redirect('/dashboard')->with('success-message', 'Updated successfully');          
        }else{
            return redirect('/dashboard')->with('alert-message', 'Unauthorized page');
        }
        
    }

    public function deleteVote($id){
        $user_id = auth()->user()->id;
        $vote = Votes::find($id);
        
        if($user_id == $vote->user_id){
            $svotes = $vote->s_vote()->get();
            foreach($svotes as $svote){
                $items = $svote->item()->orderBy('id')->get();
                foreach($items as $item){
                    $item->deleteChoices();
                    $item->delete();
                }
                $svote->delete();
            }
            $vote->delete();

            return redirect('/dashboard')->with('success-message', 'Vote deleted successfully');            
        }else{
            return redirect('/dashboard')->with('alert-message', 'Unauthorized page');
        }
        
    }

    public function deleteSVote($id){
        $user_id = auth()->user()->id;
        $svote = SVote::find($id);
        $vote_id = $svote->vote()->first()->id;
        
        if($user_id == $svote->vote()->first()->user_id){
            $items = $svote->item()->get();
            foreach($items as $item){
                $item->deleteChoices();
                $item->delete();
            }
            $svote->delete();
            return redirect('/vote/'.$vote_id)->with('success-message', 'Vote deleted successfully');            
        }else{
            return redirect('/dashboard')->with('alert-message', 'Unauthorized page');
        }
        
    }

    public function makeChoise(Request $request){
        $user = auth()->user();
        
        if($request['votetype'] == 1){
            $item = VoteItem::find($request['option_value']);
            $user->choices()->attach($item);
        }else if($request['votetype'] == 2){
            foreach($request['check_option'] as $k=>$v){
                $item = VoteItem::find($v);
                $user->choices()->attach($item);
            }
        }else if($request['votetype'] == 3){
            $item = VoteItem::where('title', '=', $request['personal'])->first();
            if($item === null){
                $item = new VoteItem();
                $item->title = $request['personal'];
                $item->s_vote_id = $request['voteid'];
                $item->save();
                $user->choices()->attach($item);
            }else{
                $user->choices()->attach($item);
            }          
        }
        return redirect()->back();
    }

    public function reVote(Request $request){
        $user = auth()->user();
        $vote_s = SVote::find($request['revote_id']);
        $vote_id = $vote_s->vote()->first()->id;

        $items = $vote_s->item()->orderBy('id')->get();
        foreach($items as $item){
            $user->choices()->detach($item);
            if($vote_s->type == 3 && $item->countVotes() == 0){
                $item->delete();
            }
        }
        return redirect('/vote/'.$vote_id);
    }
}
