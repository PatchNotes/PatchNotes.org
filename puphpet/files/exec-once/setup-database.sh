#!/bin/bash

cd /var/www/patchnotes/

php artisan migrate --env=local
php artisan migrate --env=testing