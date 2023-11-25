<?php

namespace App\Http\Resources\v1;

use App\Models\Schedule;
use App\Traits\ApiResources;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'slug' => $this->slug,
            'type' => $this->checkSubscription(),
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'is_first_login' => $this->is_first_login == 1 ? true : false ,
            'total_schedule' => $this->schedules()->count(),
            'phone_verified_at' => $this->phone_verified_at,
            'phone_number' => $this->phone_number,
            // 'otp' => $this->otp,
            'provider_name' => $this->provider_name,
            'sub' => $this->sub,
        ];
    }

    public function checkSubscription() {
        if($this->subscription && $this->subscription->active()->first()){
            return "Premium";
        }

        return "Free";
    }
}
