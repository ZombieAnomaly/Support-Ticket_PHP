<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Votes;
use App\Ticket;
use illuminate\Support\Facades\Auth;
use App\libs\DataBaseInterfaces\VotesI as VoteInterface;


class VotesController extends Controller
{
    protected $votesObject;
    
    public function __construct(VoteInterface $VI)
    {
        $this->middleware('auth');
        $this->votesObject = $VI;
    }

    public function upVote(Request $request)
    {
        $this->validate($request, [
            'ticket'   => 'required'
        ]);

        $this->votesObject->Upvote(
            $request->input('ticket'),
            Auth::user()->id
        );
        return redirect()->back()->with("status", "Your Up vote has been counted.");
    }

    public function downVote(Request $request)
    {
        $this->validate($request, [
            'ticket'   => 'required'
        ]);
        
        $this->votesObject->Downvote(
            $request->input('ticket'),
            Auth::user()->id
        );
        return redirect()->back()->with("status", "Your Down vote has been counted.");
    }

    public function UpdateTotal($ticket_id)
    {
        $total = $this->votesObject->Totalvotes($ticket_id);

        return $total;
        
    }


}


//remove index function. Instead get all votes on the ticket controller and pass data to view from TicketController@index.
//keep upvote and downvotes the same.