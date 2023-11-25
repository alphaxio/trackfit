<?php

namespace App\Http\Resources\v1;

use App\Models\BodyPart;
use App\Traits\ApiResources;
use Illuminate\Http\Resources\Json\JsonResource;

class ExerciseProgressBodyPartResource extends JsonResource
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
            'body_part' => new BodyPartResource(BodyPart::where('id', $this->body_part_id)->first()),
        ];
    }
}
