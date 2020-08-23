<?php

namespace HappyCasts\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{

    /**
     * Show the subscribe page
     *
     * @return view
     */
    public function showSubscriptionForm()
    {
        return view('subscribe');
    }

    /**
     * Handle an incoming request
     *
     * @return response()
     */
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

    /**
     * Handle an incoming request
     *
     * @return redirect()
     */
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
