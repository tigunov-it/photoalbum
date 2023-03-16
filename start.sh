#!/bin/bash

cd -- "$(dirname -- "${BASH_SOURCE[0]}")"

if [ ! -d photoalbum_front ]; then
    git clone git@github.com:tsoyvi/photoalbum_front.git
    cd photoalbum_front
    git switch lesson_2 # Delete
    cd ..
fi

if [ ! -f .env ]; then
    cp .env.example .env
fi

source .env
export DOCKER_USER=${USER:-$(whoami)}
export DOCKER_UID=${UID:-$(id -u)}

docker compose down
docker compose up -d --build

docker compose exec app composer install

if [ ! -L public/storage ]; then
    docker compose exec app php artisan storage:link
fi

docker compose exec app php artisan optimize:clear
docker compose exec app php artisan migrate:fresh --seed
docker compose exec app php artisan l5-swagger:generate

docker compose exec node npm ci
docker compose exec node npm run build
