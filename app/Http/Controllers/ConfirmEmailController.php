<?php

namespace HappyCasts\Http\Controllers;

use Illuminate\Http\Request;
use HappyCasts\User;

class ConfirmEmailController extends Controller
{

    public function index()
    {
        $token = request('token');
        $user = User::where('confirm_token', request('token'))->first();

        if ($user) {
            $user->confirm();
            session()->flash('success', 'Your email has been confirmed.');
            return redirect('/');
        } else {
            session()->flash('error', 'Confirmation token not recognised.');
            return redirect('/');
        }
    }
}
