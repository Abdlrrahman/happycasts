<?php

namespace HappyCasts\Http\Controllers;

use HappyCasts\User;

class ProfilesController extends Controller
{

    /**
     * Show the profile page
     *
     * @param User $user
     * @return view
     */
    public function index(User $user)
    {
        return view('profile')
            ->withUser($user)
            ->withSeries($user->seriesBeingWatched());
    }

    /**
     * Handle an incoming request
     *
     * @return response()
     */
    public function updateCard()
    {
        $this->validate(request(), [
            'stripeToken' => 'required'
        ]);
        $token = request('stripeToken');
        $user = auth()->user();

        $user->updateCard($token);
        return response()->json('ok');
    }
}
