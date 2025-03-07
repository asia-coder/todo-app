FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    bash \
    git \
    unzip \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    libzip-dev \
    libpq-dev \
    oniguruma-dev \
    icu-dev \
    mysql-client \
    shadow \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install gd mbstring pdo pdo_pgsql pdo_mysql zip intl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Создаем пользователя для безопасного запуска PHP
RUN useradd -G www-data,root -u 1000 -d /home/laravel laravel \
    && mkdir -p /home/laravel \
    && chown -R laravel:www-data /home/laravel

RUN chown -R laravel:www-data /var/www \
    && chmod -R 755 /var/www

WORKDIR /var/www/app

# Копируем скрипт и даем права на выполнение
COPY scripts/install-laravel.sh /usr/local/bin/install-laravel.sh
RUN chmod +x /usr/local/bin/install-laravel.sh

USER laravel

CMD ["sh", "-c", "/usr/local/bin/install-laravel.sh && php-fpm"]
