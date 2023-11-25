<?php

namespace App\Contracts;

use App\Models\Payment;
use App\Models\User;
use App\Models\Schedule;
use App\Models\Subscription;
use App\Models\SubscriptionFeature;
use App\Models\SubscriptionPlan;
use Illuminate\Database\Eloquent\Collection;

interface SubscriptionContract
{
    public function getSubscriptionFeatures(): ?Collection;
    public function getSubscriptionPlans(): ?Collection;
    public function checkSubscriptionPlan(int $id): ?SubscriptionPlan;
    public function checkSubscription(User $user);
    public function createSubscription(
        User $user,
        $subscription_plan_id,
        $start_date,
        $end_date,
        $renewal_date,
    ): ?Subscription;
    public function validateSubscription(User $user, int $subscription_id);
    public function createPayment(
        User $user,
        Subscription $subscription,
        $transaction_id,
        $amount,
        $status,
        $payment_method,
        $payment_type,
        $payment_response = null,
    ): ?Payment;
    public function validatePayment($transaction_id): bool;
    public function updateSubscription(Subscription $subscription, SubscriptionPlan $subscription_plan,  $start_date, $end_date, $renewal_date): Subscription;
}
