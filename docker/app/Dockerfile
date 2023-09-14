FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    apt-utils \
    libpq-dev \
    libpng-dev \
    libzip-dev \
    zip unzip \
    git \
    nginx && \
    docker-php-ext-install pdo_mysql && \
    docker-php-ext-install bcmath && \
    docker-php-ext-install gd && \
    docker-php-ext-install zip && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# COPY ./_docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

WORKDIR /var/www/hotels_laravel

COPY ./docker/nginx/conf.d/* /etc/nginx/sites-available/

RUN ln -s /etc/nginx/sites-available/hotels.nginx.conf /etc/nginx/sites-enabled/

RUN rm /etc/nginx/sites-available/default && rm /etc/nginx/sites-enabled/default

COPY . .

RUN chmod -R 755 /var/www/hotels_laravel/storage \
    && chown -R www-data:www-data /var/www/hotels_laravel/storage

# CMD ["nginx", "-g", "daemon off;"]

CMD service nginx start && php-fpm
