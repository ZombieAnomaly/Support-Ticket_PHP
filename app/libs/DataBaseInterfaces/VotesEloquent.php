<?php

namespace App\libs\DataBaseInterfaces;

use Illuminate\Support\Facades\DB;
use App\libs\DataBaseInterfaces\VotesI;
use App\Votes;

class VotesEloquent implements VotesI {
    protected $votes;

    function __construct(Votes $a) {
        $this->votes = $a;
    }

    public function GetVotes(){
        $votes = DB::table('Votes')->get();
        return $votes;
    }

    public function GetTopVotes(){
        $votes = DB::table('Votes')
        ->select('*', DB::raw('SUM(up) - SUM(down) as TotalVotes'))
        ->orderBy('TotalVotes', 'DESC')
        ->groupBy('ticket_id')
        ->get();
        return $votes;
    }   
    public function Totalvotes($ticket_id){

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

    public function Upvote($ticket, $userID){
        $vote = Votes::updateOrCreate([
            'user_id'   => $userID,
            'ticket_id'  => $ticket,
        ],[
            'up' => 1,
            'down' => 0,
        ]);
    }

    public function Downvote($ticket, $userID){
        $vote = Votes::updateOrCreate([
            'user_id'   => $userID,
            'ticket_id'  => $ticket,
        ],[
            'up' => 0,
            'down' => 1,
        ]);
    }

}