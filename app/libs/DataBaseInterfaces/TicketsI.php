<?php

namespace App\libs\DataBaseInterfaces;

interface TicketsI {
    public function getTickets();
    public function getTopTickets();
    public function StoreTicket($title, $userID, $ticket, $category, $priority, $visibility, $message, $mailer);
    public function RetrieveSingleTicket($ticket_id);

}