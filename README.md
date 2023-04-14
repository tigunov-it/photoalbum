# Photoalbum

## Установка локально через Docker

Описано для ОС Linux Ubuntu. Для других ОС можно адаптироваться.

1. Установка докер

    https://docs.docker.com/engine/install/ubuntu/

    https://docs.docker.com/engine/install/linux-postinstall/

2. Установка docker-compose

    https://docs.docker.com/compose/install/

3. Клонируем проект

    ```bash
    git@github.com:tigunov-it/photoalbum.git
    ```

4. Переходим в папку проекта

    ```bash
    cd photoalbum/
    ```

5. Запускаем скрипт

    ```bash
    ./start.sh
    ```

    Скрипт склонирует репозиторий фронта и выполнит все необходимые команды.

    Этот скрипт можно добавить в автозапуск.

## Проверка кода через rector

```bash
vendor/bin/rector process src
```

где `src` - путь к файлу или папке

## Генерация swagger-документации

```bash
php artisan l5-swagger:generate
```

Документация открывается по адресу: `/api/v1/documentation`

## Примеры алиасов для Linux

В терминале:

```bash
nano ~/.bash_aliases
```

Вставляем:

```bash
alias docker-up='docker compose up -d --build'
alias docker-down='docker compose down'
alias docker-restart='docker-down && docker-up'
alias docker-stop='docker stop $(docker ps -qa) && docker rm $(docker ps -qa)'

docker-compose() {
    command docker compose "$@"
}

php() {
    command docker compose exec app php "$@"
}

composer() {
    command docker compose exec app composer "$@"
}

rector() {
    command docker compose exec app vendor/bin/rector process "$@"
}

npm() {
    command docker compose exec node npm "$@"
}
```

Проверяем, чтобы файл `~/.bash_aliases` был подключен в `~/.bashrc`

```bash
nano ~/.bashrc
```

Если не подключен, вставляем в конце файла:

```bash
if [ -f ~/.bash_aliases ]; then . ~/.bash_aliases fi
```

Перезагружаем терминал:

```bash
source ~/.bashrc
```
