<?php

namespace App\Http\Resources\v1;

use App\Traits\ApiResources;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
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
            'subscription_plan_id' => $this->subscription_plan_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'renewal_date' => $this->renewal_date,
            'last_name' => $this->last_name,
            'subscription' => new SubscriptionPlanResource($this->subscription_plan),
        ];
    }
}
