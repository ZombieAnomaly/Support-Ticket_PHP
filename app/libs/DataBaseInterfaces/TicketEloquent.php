<?php

namespace App\libs\DataBaseInterfaces;

use App\libs\DataBaseInterfaces\TicketsI;
use App\Mailers\AppMailer;
use App\Ticket;
use illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketEloquent implements TicketsI {
    protected $tickets;

    function __construct(Ticket $a) {
        $this->tickets = $a;
    }
    
    public function getTickets(){
        return $this->tickets->getQuery();

    }

    public function GetTopTickets(){
        $top = DB::table('votes')
       
        ->Join('tickets', 'votes.ticket_id', '=', 'tickets.ticket_id')
        //->select('votes.*','tickets.*')
        ->select(DB::raw('SUM(votes.up) - SUM(votes.down) as TotalVotes, tickets.*'))
        ->where('visibility','=',1)
        ->orderBy('TotalVotes', 'DESC')
        ->groupBy('ticket_id')
        ->get();
        
        return $top;
    }

    public function RetrieveSingleTicket($ticket_id){
        return $this->tickets
        ->where('ticket_id', $ticket_id)
        ->firstOrFail();

    }

    public function StoreTicket($title, $userID, $ticket, $category, $priority, $visibility, $message, $mailer){
        $ticket = new Ticket([
            'title'     => $title,
            'user_id'   => $userID,
            'ticket_id' => $ticket,
            'category_id'  => $category,
            'priority'  => $priority,
            'visibility' => $visibility,
            'message'   => $message,
            'status'    => "Open",
        ]);

        $ticket->save();

        $mailer->sendTicketInformation(Auth::user(), $ticket);

        return $ticket;
               
    }
}