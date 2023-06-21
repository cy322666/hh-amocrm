#!/bin/bash

chmod -R 777 storage
chmod -R 777 vendor

#composer install
#
#php artisan key:generate

#composer require laravel/octane --with-all-dependencies

#php artisan horizon:install

#php artisan telescope:install

php artisan octane:install --server="swoole"

php artisan octane:start --server="swoole" --host="0.0.0.0" --workers=2 --task-workers=1 --max-requests=300 --watch ;
