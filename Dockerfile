FROM dunglas/frankenphp:1.12.3-php8.4-bookworm AS base

WORKDIR /app

RUN install-php-extensions \
    bcmath \
    exif \
    gd \
    intl \
    mbstring \
    opcache \
    pdo_sqlite \
    sqlite3 \
    zip

RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && { \
        echo 'display_errors=Off'; \
        echo 'expose_php=Off'; \
        echo 'memory_limit=256M'; \
        echo 'max_execution_time=60'; \
        echo 'max_input_time=60'; \
        echo 'post_max_size=32M'; \
        echo 'upload_max_filesize=32M'; \
        echo 'max_file_uploads=20'; \
        echo 'opcache.enable=1'; \
        echo 'opcache.enable_cli=1'; \
        echo 'opcache.validate_timestamps=0'; \
        echo 'opcache.revalidate_freq=0'; \
        echo 'opcache.memory_consumption=128'; \
        echo 'opcache.interned_strings_buffer=16'; \
        echo 'opcache.max_accelerated_files=10000'; \
    } > "$PHP_INI_DIR/conf.d/99-production.ini"

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

FROM base AS vendor

COPY composer.json composer.lock artisan ./
COPY app ./app
COPY bootstrap ./bootstrap
COPY config ./config
COPY database ./database
COPY public ./public
COPY resources ./resources
COPY routes ./routes

RUN mkdir -p \
    bootstrap/cache \
    storage/app/private/livewire-tmp \
    storage/app/public \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/testing \
    storage/framework/views \
    storage/logs

RUN composer install \
    --no-dev \
    --prefer-dist \
    --no-interaction \
    --no-progress \
    --optimize-autoloader

FROM node:22-bookworm-slim AS frontend

WORKDIR /app

COPY .npmrc package.json package-lock.json vite.config.js ./
COPY resources ./resources
COPY public ./public

RUN npm ci
RUN npm run build

FROM base AS runtime

WORKDIR /app

LABEL org.opencontainers.image.source="https://github.com/jarasa03/primero-el-voleibol"

COPY --from=vendor /app /app
COPY --from=frontend /app/public/build /app/public/build
COPY Caddyfile /etc/frankenphp/Caddyfile
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh

RUN chmod 755 /usr/local/bin/entrypoint.sh

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["frankenphp", "run", "--config", "/etc/frankenphp/Caddyfile"]
