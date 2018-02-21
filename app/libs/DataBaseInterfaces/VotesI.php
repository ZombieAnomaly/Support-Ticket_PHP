<?php

namespace App\libs\DataBaseInterfaces;

interface VotesI {
    public function GetVotes();
    public function GetTopVotes();
    public function Totalvotes($ticket_id);
    public function Upvote($ticket, $userID);
    public function Downvote($ticket, $UserID);
}