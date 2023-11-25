<?php

namespace App\Http\Resources\v1;

use App\Traits\ApiResources;
use Illuminate\Http\Resources\Json\JsonResource;

class ExerciseProgressImageResource extends JsonResource
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
            'image_type' => $this->image_type,
            'image_url' => $this->image_url
        ];
    }
}
