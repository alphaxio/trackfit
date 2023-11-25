<?php

namespace App\Services;

use App\Contracts\SettingContract;
use App\Models\DynamicContent;
use App\Models\FaqQuery;
use App\Models\FaqTopic;
use App\Models\Inquiry;
use App\Models\Setting;
use App\Models\User;
use App\Models\Ticket;
use App\Models\TicketComment;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Psr\SimpleCache\InvalidArgumentException;

final class SettingService  implements SettingContract
{
    public function __construct(
        private Inquiry $inquiryModel,
        private Ticket $ticketModel,
        private DynamicContent $dynamicContentModel,
        private FaqTopic $faqTopicModel,
        private FaqQuery $faqQueryModel,
        private TicketComment $ticketCommentModel
    ) {}

    /**
     * @param Inquiry $inquiry
     * @throws InvalidArgumentException
     */

    public function getInquiry(): ?Collection
    {
        $data = $this->inquiryModel->get();

        return $data;
    }

    public function getTicketList(): ?Collection
    {
        $data = $this->ticketModel->where('user_id', Auth::id())->get();

        return $data;
    }

    public function checkInquiry(int $id)
    {
        $query = $this->inquiryModel->query();

        $inquiry = $query->whereId($id)->first();

        return $inquiry;
    }

    public function storeTicket(User $user, $inquiry = null, $title, $content): ?Ticket
    {
        /** @var Ticket $ticket */
        $ticket = $this->ticketModel->newModelInstance();
        $ticket->user_id = $user->id;
        $ticket->inquiry_id = $inquiry;
        $ticket->title = $title;
        $ticket->content = $content;
        $ticket->save();

        return $ticket;
    }

    public function getFaqs(): ?Collection
    {
        $query = $this->faqTopicModel->query();

        $faqs = $query->with('faqQuery')->get();

        return $faqs;
    }


    public function getTerms(): ?DynamicContent
    {
        $query = $this->dynamicContentModel->query();

        $terms = $query->whereType($this->dynamicContentModel::$TERMS)->first();

        return $terms;
    }

    public function getPolicies(): ?DynamicContent
    {
        $query = $this->dynamicContentModel->query();

        $policies = $query->whereType($this->dynamicContentModel::$POLICY)->first();

        return $policies;
    }

    public function getContact(): ?Collection
    {
        $query = $this->dynamicContentModel->query();

        $contacts = $query->whereType($this->dynamicContentModel::$CONTACT)->get();

        return $contacts;
    }

    public function checkTicket(int $id)
    {
        $query = $this->ticketModel->query();

        $ticket = $query->whereId($id)->where('user_id', Auth::id())->first();

        return $ticket;
    }


    public function storeTicketComment(Ticket $ticket, User $user, $content): ?Ticket
    {
       $ticket->ticketComment()->create([
            'content' => $content,
            'user_id' => $user->id,
       ]);

        return $ticket;
    }

}


