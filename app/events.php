<?php

/*
|--------------------------------------------------------------------------
| Saasy Event Handlers
|--------------------------------------------------------------------------
|
| This file lists the event handlers used by Saasy
|
*/

// Perform using login events
Event::listen('auth.login', function($user)
{
    $user->last_login = new DateTime;
    $user->save();
});

// Perform user logout events
Event::listen('auth.logout', function($user)
{

});