<?php

namespace App\Contracts;

use App\Models\DynamicContent;
use App\Models\Inquiry;
use App\Models\Setting;
use App\Models\Ticket;
use App\Models\TicketComment;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface SettingContract
{
    public function getInquiry(): ?Collection;

    public function getTicketList():? Collection;

    public function checkInquiry(int $id);

    public function storeTicket(
        User $user,
        $inquiry = null,
        $title,
        $content,

    ): ?Ticket;

    public function getFaqs(): ?Collection;
    public function getTerms(): ?DynamicContent;
    public function getPolicies(): ?DynamicContent;
    public function getContact(): ?Collection;

    public function checkTicket(int $id);

    public function storeTicketComment(
        Ticket $ticket,
        User $user,
        $content
    ): ?Ticket;

}
