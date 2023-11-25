<?php

namespace App\Http\Resources\v1;

use App\Models\Subscription;
use App\Traits\ApiResources;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'id'                    => $this->id,
            'user_id'               => $this->user_id,
            'subscription_id'       => $this->subscription_id,
            'transaction_id'        => $this->transaction_id,
            'amount'                => $this->amount,
            'status'                => $this->status,
            'payment_method'        => $this->payment_method,
            'payment_type'          => $this->payment_type,
            'payment_response'      =>$this->payment_response,
            'subscription'          => Subscription::where('id', $this->subscription_id)->first(),
        ];
    }
}
