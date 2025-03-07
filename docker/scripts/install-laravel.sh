#!/bin/bash

# Основная папка проекта
PROJECT_PATH="/var/www/app"
TEMP_PATH="/var/www/temp-laravel"

# Проверяем, установлен ли Laravel
if [ -f "$PROJECT_PATH/artisan" ]; then
    echo "✅ Laravel уже установлен, пропускаем установку."
    exit 0
fi

echo "⚡ Установка Laravel началась..."

mkdir $TEMP_PATH

# Даем права на создание папок
chmod -R 775 $TEMP_PATH

# Устанавливаем Laravel во временную папку - (поменял версию на 9 из за требования задания)
composer create-project --prefer-dist laravel/laravel:^9.0 $TEMP_PATH

# Включаем dotglob, чтобы `cp` копировал скрытые файлы
shopt -s dotglob

# Копируем все файлы из временной папки в проект
cp -r $TEMP_PATH/* $PROJECT_PATH/

# Отключаем dotglob (чтобы не влияло на другие команды)
shopt -u dotglob

# Удаляем временную папку
rm -rf $TEMP_PATH

# Копируем .env
cp $PROJECT_PATH/.env.example $PROJECT_PATH/.env

# Устанавливаем зависимости
composer install --working-dir=$PROJECT_PATH

# Настраиваем права
chmod -R 775 $PROJECT_PATH/storage $PROJECT_PATH/bootstrap/cache

# Генерируем APP_KEY
php $PROJECT_PATH/artisan key:generate

echo "✅ Laravel установлен успешно!"
