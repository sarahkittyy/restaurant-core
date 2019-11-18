# restaurant-core

A demo restaurant app

## Notes 

* There's a lot of security vulnerabilities, with it being very easy for anyone to set up a script to overload whatever machine is hosting this. This is just a demo site, though, so I"m not too concerned.
* This... has been a great way to figure out how I *should* structure my CSS.

## Features

* Upload restaurants
* View restaurant details
* Restaurant submission validation
* Inconsistent curly-brace styling
* DB Seeders
* Endpoints for general / specific / average reviews
* Upload and view reviews
* Restaurant sorting

## Running the Dev Environment

A local version of laravel homestead is used.

```bash
# set up homestead
git clone git@github.com:sarahkittyy/restaurant-core.git
cd restaurant-core
composer update
vagrant up
# initialize migrations
php artisan migrate
php artisan db:seed --class=RestaurantSeeder
```

Then you can open 192.168.10.10 in your local browser to view the test page.