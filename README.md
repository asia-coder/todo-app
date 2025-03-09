## TaskApp

Тестовое задание для компании

## Особенности
- Используется Docker для локального развертывания
- Проект создан на фреймворке Laravel 9
- Версия PHP 8.3
- Используется база данных PostgreSQL

## Установка

1. Переходим в корневую директорию проекта после git клонирования
2. Копируем файл .env.example в .env
3. Запускаем команду `docker compose up -d` чтобы собрать и запустить контейнеры
4. Запускаем команду `docker compose exec app composer install` чтобы установить все зависимости
5. Запускаем команду `docker compose exec app php artisan key:generate` чтобы сгенерировать ключ приложения
6. Запускаем команду `docker compose exec app php artisan migrate` чтобы создать таблицы в базе данных

## Доп. информация
- Для доступа к приложению переходим по адресу http://localhost:8000
- Страница swagger документации доступна по адресу http://localhost:8000/swagger
- В качестве драйвера для Laravel Scout используется `database` с полнотекстовым поиском
- В качестве первичных ключей используются UUID для таблиц `tasks` и `users`

## Тестирование
`docker compose exec app php artisan test`
