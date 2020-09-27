#!/bin/bash

cd /var/www
if [ ! -f "/tmp/setupcompleted" ]; then
    php artisan key:generate
    php artisan migrate
    php artisan db:seed
    touch /tmp/setupcompleted
fi
php-fpm