<?php

namespace App\Http\Controllers\API\v1;

use App\Contracts\SubscriptionContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Subscription\PaymentRequest;
use App\Http\Requests\Subscription\SubscriptionRequest;
use App\Http\Resources\v1\JsonResponseResource;
use App\Http\Resources\v1\PaymentResource;
use App\Http\Resources\v1\SubscriptionFeatureResource;
use App\Http\Resources\v1\SubscriptionPlanResource;
use App\Http\Resources\v1\SubscriptionResource;
use App\Models\Payment;
use App\Traits\ApiResponses;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    use ApiResponses;

    public function __construct(
        private SubscriptionContract $subscriptionService,
    ) {
    }


    public function getSubcriptionInfo()
    {
        try {
            $subcription_features = $this->subscriptionService->getSubscriptionFeatures();
            $subcription_plans = $this->subscriptionService->getSubscriptionPlans();

            $message = 'Subcriptions Info Fetched Successfully';
            return $this->okayApiResponse([
                'message'  => $message,
                'features' => SubscriptionFeatureResource::collection($subcription_features),
                'plans' => SubscriptionPlanResource::collection($subcription_plans),
            ]);
        } catch (\Exception $exception) {
            return $this->errorApiResponse($exception->getMessage(), 400);
        }
    }

    public function subscription(SubscriptionRequest $request):\Illuminate\Http\JsonResponse
    {
        try {
            $user = Auth::user();
            $validator = $request->validated();

            $subscription = $user->subscription;
            $subscription_plan = $this->subscriptionService->checkSubscriptionPlan($validator['subscription_plan_id']);

            if(is_null($subscription_plan)){
                return $this->errorApiResponse('Subscription Plan Not Found', 404);
            }

            if(!$subscription){
                $start_date = null;
                $end_date = null;
                $renewal_date = null;

                $subscription = $this->subscriptionService->createSubscription(
                    $user,
                    $subscription_plan->id,
                    $start_date,
                    $end_date,
                    $renewal_date
                );
            }

            if($subscription->end_date >= Carbon::now()){
                return $this->errorApiResponse('You current subscription still active' , 400);
            }

            return $this->okayApiResponse([
                "message" => "Subscription Initiated Successfully",
                "subscription" =>  new SubscriptionResource($subscription),
            ]);
        } catch (\Throwable $th) {
            return $this->errorApiResponse($th->getMessage(), 400);
        }
    }

    public function payment(PaymentRequest $request):\Illuminate\Http\JsonResponse
    {
        try {
            $user = Auth::user();
            $validator = $request->validated();

            $validate_payment = $this->subscriptionService->validatePayment($validator["transaction_id"]);

            if ($validate_payment) return $this->errorApiResponse('Duplicate Subscription', 400);

            $subscription = $this->subscriptionService->validateSubscription($user, $validator['subscription_id']);

            if(is_null($subscription))
            {
                return $this->errorApiResponse('Invalid Subscription', 400);
            }
            $subscription_plan = $this->subscriptionService->checkSubscriptionPlan($subscription->subscription_plan_id);

            if(is_null($subscription_plan))
            {
                return $this->errorApiResponse('Invalid Subscription Plan', 400);
            }
            $payment_type = null; //I do not know where this is getting its data from
            $payment_response = null;

            $payment = $this->subscriptionService->createPayment(
                $user,
                $subscription,
                $validator['transaction_id'],
                $subscription_plan->price,
                Payment::$PAID,
                $payment_type,
                $payment_response,
            );

            $start_date = now();
            $end_date = Carbon::now()->addDays($subscription_plan->duration);
            $renewal_date = null;

            $update_subscription = $this->subscriptionService->updateSubscription($subscription, $subscription_plan, $start_date, $end_date, $renewal_date );

            if(!$update_subscription)
            {
                return $this->errorApiResponse('Subscription Not Updated', 400);
            }

            return $this->okayApiResponse([
                "message" => "Payment Received Successfully",
                "payment" =>  new PaymentResource($payment),
            ]);

        } catch (\Throwable $th) {
            return $this->errorApiResponse($th->getMessage(), 400);
        }
    }
}
