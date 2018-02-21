<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Ticket;
use App\Mailers\AppMailer;
use illuminate\Support\Facades\Auth;
use App\libs\DataBaseInterfaces\TicketsI as TicketInterface;
use App\libs\DataBaseInterfaces\CategoryI as CategoryInterface;
use App\libs\DataBaseInterfaces\VotesI as VotingInterface;
// use App/Ticket;
// use App/Mailers/AppMailer;
// use Illuminate\Support\Facades\Auth;

class TicketsController extends Controller
{
    protected $ticketObject;
    protected $categoryObject;
    protected $votesObject;
    public function __construct(TicketInterface $TI, CategoryInterface $CI, VotingInterface $VI)
    {
        $this->middleware('auth');
        $this->ticketObject = $TI;
        $this->categoryObject = $CI;
        $this->votesObject = $VI;
    }

    public function create()
    {
        $categories = $this->categoryObject->GetCategories();
        //Category::all();
    
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
            
            $ticket = $this->ticketObject->StoreTicket($request->input('title'), 
                Auth::user()->id, 
                strtoupper(str_random(10)),
                $request->input('category'),
                $request->input('priority'),
                $request->input('visibility'),
                $request->input('message'),
                $mailer
            );

            $url = url('./tickets/' . $ticket->ticket_id); 

            return redirect()->back()->with("status",' A ticket with ID: <a href="'.$url.'"> ' .$ticket->ticket_id .'</a> has been opened.');
    }
    
    public function userTickets()
    {
        $tickets = $this->ticketObject->getTickets()
        ->where('user_id','=',Auth::user()->id)
        ->paginate(10);
        $categories = $this->categoryObject->GetCategories();
    
        return view('tickets.user_tickets', compact('tickets', 'categories'));
    }
    public function recentTickets()
    {
        $tickets = $this->ticketObject->getTickets()
        ->where('visibility','=',1)
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        $categories = $this->categoryObject->GetCategories();
        $votes = $this->votesObject->GetVotes();
    
        return view('tickets.recent_tickets', compact('tickets', 'categories','votes'));
    }

    public function topTickets()
    {
        $tickets = $this->ticketObject->getTopTickets();
        $categories = $this->categoryObject->GetCategories();

        return view('tickets.top_tickets', compact('tickets', 'categories'));
    }
    public function publicTickets()
    {
        $tickets = $this->ticketObject->getTickets()
        ->where('visibility', 1)
        ->paginate(10);

        $categories = $this->categoryObject->GetCategories();
        $votes = $this->votesObject->GetVotes();
        
        
        return view('tickets.public_tickets', compact('tickets', 'categories','votes'));
    }

    public function show($ticket_id)
    {
        $ticket = $this->ticketObject->RetrieveSingleTicket($ticket_id);

        $comments = $ticket->comments;
    
        $category = $ticket->category;
    
        return view('tickets.show', compact('ticket', 'category', 'comments'));
    }
   
    public function index()
    {
        $tickets = $this->ticketObject->getTickets()->paginate(10); //Ticket::paginate(10);
        $categories = $this->categoryObject->GetCategories();
    
        return view('tickets.index', compact('tickets', 'categories'));
    }

    public function indexPublic()
    {
        $tickets = $this->ticketObject->getTickets()
        ->where('visibility', 1)
        ->inRandomOrder()
        ->paginate(10); //Ticket::paginate(10);
        $categories = $this->categoryObject->GetCategories();
        $votes = $this->votesObject->GetVotes();

        return view('welcome', compact('tickets', 'categories', 'votes'));
    }
    public function close($ticket_id, AppMailer $mailer)
    {
        $ticket = $this->ticketObject->RetrieveSingleTicket($ticket_id);

        $ticket->status = 'Closed';
    
        $ticket->save();
    
        $ticketOwner = $ticket->user;
    
        $mailer->sendTicketStatusNotification($ticketOwner, $ticket);
    
        return redirect()->back()->with("status", "The ticket has been closed.");
    }
}
