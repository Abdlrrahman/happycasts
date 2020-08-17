<?php

namespace HappyCasts\Http\Controllers;

use HappyCasts\User;

class ProfilesController extends Controller
{
    public function index(User $user)
    {
        return view('profile')
            ->withUser($user)
            ->withSeries($user->seriesBeingWatched());
    }
}
