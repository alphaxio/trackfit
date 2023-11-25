<?php

namespace App\Http\Resources\v1;

use App\Traits\ApiResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExerciseBodyPartResource extends JsonResource
{
    use ApiResources;

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'                    => $this->body_part_id,
            'muscle_group_id'       => $this->muscle_group_id,
            'muscle_code'           => $this->muscle_code,
            'muscle_group'          => $this->muscle_group,
            'body_part'             => $this->body_part,
        ];
    }
}
