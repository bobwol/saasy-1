<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::group(array(
    "prefix" => "system",
), function() {
	// Cashier's failed payments
	Route::post('stripe/webhook', 'Laravel\Cashier\WebhookController@handleWebhook');

	// Test routes
	Route::group(array(
	    "prefix" => "test",
	    "before" => array("session.remove")
	), function() {
		Route::get('environment', function()
		{
			echo App::environment();
		});
	});
});
