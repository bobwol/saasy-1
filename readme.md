## Laravel PHP Framework

### Pre-Install
Setup your Stripe account, you'll need tokens to continue.
If you want to use Sentry for logging, setup a project and get your key. Set up
a team and two projects inside it - production and development.

### Configuration

1. Set the following enviroment variables in .env.local.php:

2.	Complete production and local database configuration

3.	Configure production and local environments


### Saasy Setup & Configuration
From this point forward, I'm only showing the local env setup. Repeat this
for your production environment too.

Publish the Cartalyst Sentry 2 configuration:
    php artisan config:publish cartalyst/sentry --env=local

Run the database migrations, which will install the migration table, the sentry
user table and the tenants table.

    php artisan migrate --env=local

