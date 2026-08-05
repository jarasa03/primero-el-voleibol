#!/bin/sh

set -eu

if [ -z "${APP_KEY:-}" ]; then
    printf '%s\n' 'Error: APP_KEY is empty. Set deploy/.env before starting the container.' >&2
    exit 1
fi

mkdir -p /data

if [ ! -f /data/database.sqlite ]; then
    touch /data/database.sqlite
fi

mkdir -p \
    /app/bootstrap/cache \
    /app/storage/app/private/livewire-tmp \
    /app/storage/app/public \
    /app/storage/framework/cache/data \
    /app/storage/framework/sessions \
    /app/storage/framework/testing \
    /app/storage/framework/views \
    /app/storage/logs

if [ "$(id -u)" = "0" ]; then
    chown -R www-data:www-data /data /app/bootstrap/cache /app/storage
fi

php artisan optimize:clear
php artisan migrate --force

if [ ! -e /app/public/storage ]; then
    ln -s /app/storage/app/public /app/public/storage
fi

php artisan optimize

exec "$@"
