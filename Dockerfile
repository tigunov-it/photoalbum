FROM docker.io/bitnami/laravel:10.2.2-debian-11-r1

COPY . /app

RUN composer update
RUN composer install

EXPOSE 8000
