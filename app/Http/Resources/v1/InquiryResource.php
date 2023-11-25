<?php

namespace App\Http\Resources\v1;

use App\Traits\ApiResources;
use Illuminate\Http\Resources\Json\JsonResource;

class InquiryResource extends JsonResource
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
            'name' => __('inquiries.'. $this->name, [], $locale),
        ];
    }
}
