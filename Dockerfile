FROM php:8.4-fpm

ARG UID=1000
ARG GID=1000

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git \
    nano \
    net-tools \
    libicu-dev \
    zip unzip \
    libpng-dev libonig-dev libzip-dev \
    && docker-php-ext-install intl pdo pdo_mysql mbstring zip exif pcntl gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Alinhar www-data com usuário do host
RUN groupmod -g ${GID} www-data \
    && usermod -u ${UID} -g ${GID} www-data

RUN git config --global --add safe.directory /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY . .

RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

RUN composer install --no-dev --optimize-autoloader --no-scripts

RUN mkdir -p storage framework bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

USER www-data

EXPOSE 9000

CMD ["php-fpm"]
