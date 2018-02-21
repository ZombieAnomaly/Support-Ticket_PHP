<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mailers\AppMailer;
use App\Comment;
use Auth;
use App\libs\DataBaseInterfaces\CommentsI as CommentInterface;

class CommentsController extends Controller
{

    protected $commentObject;
    public function __construct(CommentInterface $CI)
    {
        $this->commentObject = $CI;
    }

    public function postComment(Request $request, AppMailer $mailer)
    {
        $this->validate($request, [
            'comment'   => 'required'
        ]);
        
        $comment = $this->commentObject->CreateComment(
            $request->input('ticket_id'),
            Auth::user()->id,
            $request->input('comment'),
            $mailer
        );

        return redirect()->back()->with("status", "Your comment has be submitted!");
    }
}
