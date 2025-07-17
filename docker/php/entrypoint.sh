#!/bin/bash

set -e

mkdir -p /var/www/storage /var/www/bootstrap/cache
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

if [ ! -L /var/www/public/storage ]; then
  rm -rf /var/www/public/storage
  ln -s /var/www/storage/app/public /var/www/public/storage
  chown -h www-data:www-data /var/www/public/storage
fi

composer install
php artisan key:generate
php artisan storage:link

exec "$@"
