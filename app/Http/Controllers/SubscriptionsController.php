<?php

namespace HappyCasts\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    public function showSubscriptionForm()
    {
        return view('subscribe');
    }

    public function subscribe()
    {
        $yearlyId = config('services.yearly_id');
        $monthlyId = config('services.monthly_id');
        return auth()->user()
            ->newSubscription(
                request('plan'),
                (request('plan') == 'yearly' ? $yearlyId : $monthlyId)
            )->create(
                request('stripeToken')
            );
    }

    public function change()
    {
        $yearlyId = config('services.yearly_id');
        $monthlyId = config('services.monthly_id');

        $this->validate(request(), [
            'plan' => 'required'
        ]);
        $user = auth()->user();
        $plan = request('plan');
        $userPlan = $user->subscriptions->first()->stripe_plan;
        $userPlanName = $user->subscriptions->first()->name;

        if (($plan === 'yearly' ? $yearlyId : $monthlyId) === $userPlan) {
            return redirect()->back();
        }

        $user->subscription($userPlanName)->swap(($plan === 'yearly' ? $yearlyId : $monthlyId), $plan);

        return redirect()->back();
    }
}
