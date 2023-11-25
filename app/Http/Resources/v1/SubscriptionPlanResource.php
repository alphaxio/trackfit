<?php

namespace App\Http\Resources\v1;

use App\Traits\ApiResources;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionPlanResource extends JsonResource
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
        $locale = $request->header('Accept-Language') ?? app()->getLocale(); // Get the user's preferred language from the request headers

        return [
            'id' => $this->id,
            'name' => __('subscriptions.'. $this->name, [], $locale),
            'description' => __('subscriptions.'. $this->description, [], $locale),
            'price' => $this->price,
            'price_text' => '￦' . number_format($this->price) . ' per month',
        ];
    }
}
