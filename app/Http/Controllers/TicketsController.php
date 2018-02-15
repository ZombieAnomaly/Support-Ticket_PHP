<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Ticket;
use App\Mailers\AppMailer;
use illuminate\Support\Facades\Auth;

// use App/Ticket;
// use App/Mailers/AppMailer;
// use Illuminate\Support\Facades\Auth;

class TicketsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $categories = Category::all();
    
        return view('tickets.create', compact('categories'));
    }

    public function store(Request $request, AppMailer $mailer)
    {
        $this->validate($request, [
                'title'     => 'required',
                'category'  => 'required',
                'priority'  => 'required',
                'visibility' => 'required',
                'message'   => 'required'
            ]);
    
            $ticket = new Ticket([
                'title'     => $request->input('title'),
                'user_id'   => Auth::user()->id,
                'ticket_id' => strtoupper(str_random(10)),
                'category_id'  => $request->input('category'),
                'priority'  => $request->input('priority'),
                'visibility' => $request->input('visibility'),
                'message'   => $request->input('message'),
                'status'    => "Open",
            ]);
    
            $ticket->save();
    
            $mailer->sendTicketInformation(Auth::user(), $ticket);
            $url = url('./tickets/' . $ticket->ticket_id); 
            return redirect()->back()->with("status",' A ticket with ID: <a href="'.$url.'"> ' .$ticket->ticket_id .'</a> has been opened.');
    }
    
    public function userTickets()
    {
        $tickets = Ticket::where('user_id', Auth::user()->id)->paginate(10);
        $categories = Category::all();
    
        return view('tickets.user_tickets', compact('tickets', 'categories'));
    }
    public function recentTickets()
    {
        $tickets = Ticket::where('visibility',1)
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        $categories = Category::all();
    
        return view('tickets.recent_tickets', compact('tickets', 'categories'));
    }
    public function publicTickets()
    {
        $tickets = Ticket::where('visibility', 1)->paginate(10);
        $categories = Category::all();
    
        return view('tickets.public_tickets', compact('tickets', 'categories'));
    }

    public function show($ticket_id)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

        $comments = $ticket->comments;
    
        $category = $ticket->category;
    
        return view('tickets.show', compact('ticket', 'category', 'comments'));
    }

    public function index()
    {
        $tickets = Ticket::paginate(10);
        $categories = Category::all();
    
        return view('tickets.index', compact('tickets', 'categories'));
    }

    public function close($ticket_id, AppMailer $mailer)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
    
        $ticket->status = 'Closed';
    
        $ticket->save();
    
        $ticketOwner = $ticket->user;
    
        $mailer->sendTicketStatusNotification($ticketOwner, $ticket);
    
        return redirect()->back()->with("status", "The ticket has been closed.");
    }
}
