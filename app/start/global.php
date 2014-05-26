<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds',
	app_path().'/classes',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

Log::useFiles(storage_path().'/logs/laravel.log');

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code)
{
	Log::error($exception);
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

App::down(function()
{
	return Response::make("Be right back!", 503);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';

/*
|--------------------------------------------------------------------------
| Stripe Integration
|--------------------------------------------------------------------------
|
| Do a sanity check and then check that we have a Stripe key set, if we do
| then set it up for Cashier to use
*/
if (!App::runningInConsole())
{
	if ($_ENV["LARAVEL_STRIPE_KEY_PUBLIC"] && $_ENV["LARAVEL_STRIPE_KEY_SECRET"])
	{
		User::setStripeKey($_ENV["LARAVEL_STRIPE_KEY_SECRET"]);
	} else
	{
		throw new \Saasy\Error("Please set the environment variables correctly.");
	}
}

/*
|--------------------------------------------------------------------------
| Sentry Integration for logging
|--------------------------------------------------------------------------
|
*/
if (Config::has('sentry.key')) {
	$bufferHandler = new Monolog\Handler\BufferHandler(
		new Monolog\Handler\RavenHandler(
			new Raven_Client(Config::get('sentry.key')),
			Monolog\Logger::WARNING
		)
	);
	App::instance('log.buffer', $bufferHandler);
	Log::getMonolog()->pushHandler($bufferHandler);
}

// Lookup the database credentials for this user and then set our configuration
// environment up to use them

// Set the cookie subdomain
Config::set("session.domain", ".saasy.ssx.io");