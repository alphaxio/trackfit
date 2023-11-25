<?php

namespace App\Http\Resources\v1;

use App\Traits\ApiResources;
use Illuminate\Http\Resources\Json\JsonResource;

class CalenderByWeekResource extends JsonResource
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
            'day' => $this->day,
            'type' => $this->type,
            'date' => $this->date->format('Y-m-d H:i:s'),
            'status' => $this->status,
        ];
    }
}
