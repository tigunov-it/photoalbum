# photoalbum
create stage

### Проверка кода через rector
```
vendor/bin/rector process src
```
или
```
sail bin rector process src
```
где `src` - путь к файлу или папке

### Генерация swagger-документации
```
php artisan l5-swagger:generate
```
или
```
sail php artisan l5-swagger:generate
```
Документация открывается по адресу: `/api/v1/documentation`
