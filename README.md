# Pusher Channel Authentication example using the PHP Silex Framework

An example using Pusher with the [Silex](http://silex.sensiolabs.org/) PHP framework. The examples make use of the [Pusher PHP library](https://github.com/pusher/pusher-http-php).

It was built upon the [Getting Started with PHP on Heroku](https://devcenter.heroku.com/articles/getting-started-with-php) example.

## Contents

The code in this repository provides examples of how to:

* Trigger Events
* Authenticate Private Channel Subscriptions

All the code can be found in [web/index.php](web/index.php).

## Todo

* Authenticating Presence Channel Subscriptions
* Get a list of channels from the Pusher HTTP API
* Handle incoming WebHooks

## Running Locally

Make sure you have PHP, Apache and Composer installed.  Also, install the [Heroku Toolbelt](https://toolbelt.heroku.com/).

```sh
$ git clone git@github.com:pusher/pusher-php-silex-auth.git # or clone your own fork
$ cd pusher-php-silex-auth
$ composer update
$ foreman start web
```

Your app should now be running on [localhost:5000](http://localhost:5000/).

## Deploying to Heroku

```
$ heroku create
$ git push heroku master
$ heroku open
```

## Documentation

For more information on authenticating Pusher channel subscription see:

- [Triggering Events](https://pusher.com/docs/server_api_guide/interact_rest_api#publishing-events)
- [Implementing Private Authentication Endpoints](https://pusher.com/docs/authenticating_users#implementing_private_endpoints)
- [Implementing Presence Authentication Endpoints](https://pusher.com/docs/authenticating_users#implementing_private_endpoints)

For more information about using PHP on Heroku, see these Dev Center articles:

- [PHP on Heroku](https://devcenter.heroku.com/categories/php)
