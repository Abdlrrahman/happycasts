<?php

namespace HappyCasts;

use HappyCasts\Entities\Learning;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, Learning, Billable;


    protected $with = ['subscriptions'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'confirm_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Checks if user's email has been confirmed
     *
     * @return boolean
     */
    public function isConfirmed()
    {
        return $this->confirm_token == null;
    }

    /**
     * Confirm a user's email
     *
     * @return void
     */
    public function confirm()
    {
        $this->confirm_token = null;
        $this->save();
    }

    /**
     * Check if current user is an administrator
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return in_array($this->email, config('happycasts.administrators'));
    }

    /**
     * get the username
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'username';
    }
}
