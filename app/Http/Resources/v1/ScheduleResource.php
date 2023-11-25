<?php

namespace App\Http\Resources\v1;

use App\Models\Schedule;
use App\Traits\ApiResources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Schedule */
final class ScheduleResource extends JsonResource
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
            'id'                    => $this->id,
            'user_id'               => $this->user_id,
            'exercise_type_id'      => $this->exercise_type_id,
            'exercise_type'         => $this->exercise_type,
            'schedule_status'       => $this->schedule_status,
            'gender'                => $this->gender,
            'location_name'         => $this->location_name,
            'session_total_count'   => $this->session_total_count,
            'session_current_count' => $this->session_current_count,
            'number_of_months'      => $this->number_of_months,
            'trainers_name'         => $this->trainers_name,
            'weight_before'         => $this->weight_before,
            'target_weight'         => $this->target_weight,
            'weight_after'          => $this->weight_after,
            'amount'                => $this->amount,
            'amount_per_session'    => $this->amount_per_session,
            'amount_per_month'      => $this->amount_per_month,
            'start_date'            => $this->start_date ? $this->start_date->format('Y-m-d H:i:s') : null,
            'end_date'              => $this->end_date ? $this->end_date->format('Y-m-d H:i:s') : null,
            'created_at'            => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at'            => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
