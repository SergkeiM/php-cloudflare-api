ARG PHP_VERSION=8.2
FROM php:${PHP_VERSION}-cli

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libzip-dev \
        $PHPIZE_DEPS \
    && docker-php-ext-install zip \
    && pecl install pcov \
    && docker-php-ext-enable pcov \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN git config --global --add safe.directory /app

WORKDIR /app
