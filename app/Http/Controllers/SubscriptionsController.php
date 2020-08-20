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
        return auth()->user()
            ->newSubscription(
                request('plan'),
                (request('plan') == 'yearly' ? 'yearlyId' : 'monthlyId')
            )->create(
                request('stripeToken')
            );
    }

    public function change()
    {
        $this->validate(request(), [
            'plan' => 'required'
        ]);
        $user = auth()->user();
        $userPlan = $user->subscriptions->first()->stripe_plan;
        $userPlanName = $user->subscriptions->first()->name;
        if (request('plan') === $userPlan) {
            return redirect()->back();
        }

        $user->subscription($userPlan)->swap(request('plan'));
        $user->subscription($userPlanName)->swap(request('plan'));

        return redirect()->back();
    }
}
