<?php

namespace App\Services;

use App\Models\User;
use App\Models\Schedule;
use App\Models\ExerciseProgress;
use App\Contracts\ScheduleContract;
use App\Contracts\SubscriptionContract;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\SubscriptionFeature;
use App\Models\SubscriptionPlan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Collection;
use Psr\SimpleCache\InvalidArgumentException;

final class SubscriptionService implements SubscriptionContract
{
    public function __construct(
        private SubscriptionFeature $subscriptionFeatureModel,
        private SubscriptionPlan $subscriptionPlanModel,
        private Subscription $subscriptionModel,
        private Payment $paymentModel
    ) {
    }

    public function getSubscriptionFeatures(): ?Collection
    {
        $data = $this->subscriptionFeatureModel->get();

        return $data;
    }

    public function checkSubscription(User $user)
    {
        $subscription = $this->subscriptionModel->query()->where('user_id', $user->id)->first();

        return $subscription;
    }

    public function checkSubscriptionPlan(int $id): ?SubscriptionPlan
    {
        $query = $this->subscriptionPlanModel->newQuery();

        $subscription_plan = $query->where("id", $id)->first();

        return $subscription_plan;
    }

    public function getSubscriptionPlans(): ?Collection
    {
        $data = $this->subscriptionPlanModel->get();

        return $data;
    }

    public function createSubscription(
        User $user,
        $subscription_plan_id,
        // SubscriptionPlan $subscriptionPlan,
        $start_date,
        $end_date,
        $renewal_date,
    ): ?Subscription
    {
        $subscription = $this->subscriptionModel->newModelInstance();

        $subscription->user_id = $user->id;
        $subscription->subscription_plan_id = $subscription_plan_id;
        $subscription->start_date = $start_date;
        $subscription->end_date = $end_date;
        $subscription->renewal_date = $renewal_date;
        $subscription->save();

        return $subscription;
    }

    public function validateSubscription(User $user, int $subscription_id)
    {
        $query = $this->subscriptionModel->query();

        $subscription = $query->whereId($subscription_id)->whereUserId($user->id)->first();

        return $subscription;
    }

    public function validatePayment($transaction_id): bool
    {
        $query = $this->paymentModel->query();

        $validate_payment = $query->where('transaction_id', $transaction_id)->exists();

        return $validate_payment;
    }

    public function createPayment(
        User $user,
        Subscription $subscription,
        $transaction_id,
        $amount,
        $status,
        $payment_method,
        $payment_type,
        $payment_response = null,
    ): ?Payment
    {

        $payment = $this->paymentModel->newModelInstance();

        $payment->user_id = $user->id;
        $payment->subscription_id = $subscription->id;
        $payment->transaction_id = $transaction_id;
        $payment->amount = $amount;
        $payment->status = $status;
        $payment->payment_method = $payment_method;
        $payment->payment_type = $payment_type;
        $payment->payment_response = $payment_response;
        $payment->save();

        return $payment;
    }

    public function updateSubscription(
        Subscription $subscription,
        SubscriptionPlan $subscription_plan,
        $start_date,
        $end_date,
        $renewal_date
        ): Subscription
    {
        $subscription->start_date = $start_date;
        $subscription->end_date =  $end_date;
        $subscription->save();

        return $subscription;
    }
}
