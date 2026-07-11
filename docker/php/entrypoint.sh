#!/bin/sh
set -e

# Ensure Laravel writable directories exist and are usable by php-fpm
mkdir -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    storage/app/public \
    bootstrap/cache

# Bind mounts often keep host ownership; make dirs writable without forcing root ownership forever
chmod -R ug+rwx storage bootstrap/cache 2>/dev/null || true

exec "$@"
