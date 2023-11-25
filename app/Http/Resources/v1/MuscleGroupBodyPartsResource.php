<?php

namespace App\Http\Resources\v1;

use App\Models\BodyPart;
use App\Traits\ApiResources;
use Illuminate\Http\Resources\Json\JsonResource;
use Stichoza\GoogleTranslate\GoogleTranslate;

class MuscleGroupBodyPartsResource extends JsonResource
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
            'name' => __('progress.'. $this->name, [], $locale),
            'body_parts' => BodyPartResource::collection($this->bodyPart),
        ];

    }
}
