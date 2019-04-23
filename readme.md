# Быстрый старт:

- Клонируем репозиторий: ```git clone git@github.com:roadtoexp/gpn.git .```
- Инсталлируем композер: ```composer install```
- Создаем файл ```.env``` и прописывает креденшелы
- Генерируем ключ: ```php artisan key:generate```
- Запускаем миграции: ```php artisan migrate```
- Запускаем планировщик задач:
Для удаления данных в связи с разрушением сессии используется - [Планировщик задач](https://laravel.com/docs/5.8/scheduling). 
Для запуска планировщика необходимо использовать команду: 
```php artisan schedule:run```


# Реализаци:
## Авторизация пользователя

![Реализация авторизации пользователя](https://github.com/roadtoexp/gpn/blob/master/readme/auth.png)


## P.S

При выполнение тестового задания, я указал текущие слабые тегом todo и объяснил почему я считаю их слабыми 
и что нужно сделать для их "прочности".

При выполнение тестового задания были использованы следующие библиотеки:
- [Laravel IDE helper](https://github.com/barryvdh/laravel-ide-helper)
- [Guzzle](https://github.com/guzzle/guzzle)
