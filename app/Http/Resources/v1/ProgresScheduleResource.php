<?php

namespace App\Http\Resources\v1;

use App\Traits\ApiResources;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgresScheduleResource extends JsonResource
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
            'schedule_status' => $this->schedule_status,
            'exercise_type' => $this->exercise_type,
            'schedule_status' => $this->schedule_status,
            'location_name' => $this->location_name,
            'trainers_name' => $this->trainers_name,
        ];
    }
}
