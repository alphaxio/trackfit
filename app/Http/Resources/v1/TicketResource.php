<?php

namespace App\Http\Resources\v1;

use App\Models\TicketComment;
use App\Traits\ApiResources;
use Auth;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    use ApiResources;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'date' => $this->created_at,
            'status' => $this->getStatus(),
            'ticket_comment' => TicketCommentResource::collection($this->ticketComment),
            'inqury' => new InquiryResource($this->inquiry)
        ];
    }

    public function getStatus()
    {
        $agent_comment = $this->ticketComment()
            ->where('user_id', '<>', $this->user_id)
            ->latest()
            ->first();


        $status = $agent_comment ? __('tickets.Answered') : __("tickets.Waiting for reply");

        return $status;
    }
}
