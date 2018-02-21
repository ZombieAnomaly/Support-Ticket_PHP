<?php

namespace App\libs\DataBaseInterfaces;

interface CommentsI {
    public function getComments();
    public function CreateComment($ticket, $userID, $comment,$mailer);
}