<?php

namespace HappyCasts\Http\Controllers;

use HappyCasts\User;
use Illuminate\Http\Request;

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

    /**
     * Handle an incoming request
     *
     * @return response()
     */
    public function updateUser(User $user, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255|unique:users,name,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $data = $request->only('name', 'email');

        $user->update($data);
        return back();
    }
}
