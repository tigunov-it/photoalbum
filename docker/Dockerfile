FROM php:8.2.3-fpm

ARG USER
ARG UID
ARG PHP_UPLOAD_LIMIT

RUN apt update && apt install -y \
    libmagickwand-dev \
    libonig-dev \
    libpng-dev \
    libpq-dev \
    libxml2-dev \
    libzip-dev \
    zip

RUN docker-php-ext-install bcmath exif gd intl mbstring pcntl pdo_mysql soap zip

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN useradd -G www-data,root -u $UID -d /home/$USER $USER
RUN mkdir -p /home/$USER/.composer && \
    chown -R $USER:$USER /home/$USER

RUN { \
    echo "upload_max_filesize=$PHP_UPLOAD_LIMIT"; \
    echo "post_max_size=$PHP_UPLOAD_LIMIT"; \
    } > /usr/local/etc/php/conf.d/docker-php-upload-limit.ini;

USER $USER
