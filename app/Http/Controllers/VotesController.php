<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Votes;
use App\Ticket;
use illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VotesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function upVote(Request $request)
    {

        $this->validate($request, [
            'ticket'   => 'required'
        ]);

        $vote = Votes::updateOrCreate([
            'user_id'   => Auth::user()->id,
            'ticket_id'  => $request->input('ticket'),
        ],[
            'up' => 1,
            'down' => 0,
        ]);

        return redirect()->back()->with("status", "Your Up vote has been counted.");
    }

    public function downVote(Request $request)
    {
        $this->validate($request, [
            'ticket'   => 'required'
        ]);
        
        $vote = Votes::updateOrCreate([
            'user_id'   => Auth::user()->id,
            'ticket_id'  => $request->input('ticket'),
        ],[
            'up' => 0,
            'down' => 1,
        ]);

        return redirect()->back()->with("status", "Your Down vote has been counted.");
    }

    public static function UpdateTotal($ticket_id)
    {
        

        $upvotes = DB::table('Votes')
            ->where('ticket_id', $ticket_id)
            ->where('up',"=", 1)
            ->count();

        $downvotes = DB::table('Votes')
        ->where('ticket_id', $ticket_id)
        ->where('down',"=", 1)
        ->count();

        $total = $upvotes - $downvotes;
        return $total;
        
    }


}
