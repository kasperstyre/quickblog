#!/bin/bash

cd /var/www
php artisan migrate
php artisan db:seed
php-fpm