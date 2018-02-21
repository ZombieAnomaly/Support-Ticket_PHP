<?php

namespace App\libs\DataBaseInterfaces;

use App\libs\DataBaseInterfaces\CommentsI;
use App\Mailers\AppMailer;
use App\Comment;
use illuminate\Support\Facades\Auth;

class CommentsEloquent implements CommentsI {
    protected $comments;

    function __construct(Comment $a) {
        $this->comments = $a;
    }
    
    public function getComments(){
        return $this->comments->all();
    }

    public function CreateComment($ticket, $userID, $comment,$mailer){

        $comment = $this->comments->create([
            'ticket_id' => $ticket,
            'user_id'   => $userID,
            'comment'   => $comment,
        ]);

        // send mail if the user commenting is not the ticket owner
        if ($comment->ticket->user->id !== Auth::user()->id) {
            $mailer->sendTicketComments($comment->ticket->user, Auth::user(), $comment->ticket, $comment);
        }        
    }
}