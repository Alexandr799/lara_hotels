# Указываем базовый образ PHP 8.2-fpm
FROM php:8.2-fpm

# Обновляем пакеты и устанавливаем необходимые зависимости
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql gd zip

# Устанавливаем Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Создаем рабочую директорию
WORKDIR /var/www

# Копируем файлы Laravel приложения в контейнер
COPY . .

# Устанавливаем зависимости Laravel
RUN composer install

# Опционально: Выполняем миграции и сиды, если это необходимо
RUN php artisan migrate
RUN php artisan db:seed

# Указываем пользователя и группу для PHP-FPM
# (это может потребоваться, чтобы избежать проблем с правами доступа)
USER www-data

# Опционально: Указываем порт, на котором будет работать PHP-FPM
# EXPOSE 9000

# Опционально: Запускаем PHP-FPM
# CMD ["php-fpm"]

# Опционально: Если вы используете Nginx вместо Apache,
# то можете настроить его в этом файле.
