# Используем официальный образ PHP с Apache
FROM php:8.2-apache

# Устанавливаем необходимые расширения PHP
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    && docker-php-ext-install \
    zip \
    pdo_pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    ctype \
    xml

# Устанавливаем Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Копируем конфигурацию Xdebug
# Настройка Xdebug
RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.log=/var/log/xdebug.log" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.discover_client_host=1" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.log_level=7" >> /usr/local/etc/php/conf.d/xdebug.ini

# Включаем модуль Apache rewrite
RUN a2enmod rewrite

# Копируем конфигурацию Apache
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Устанавливаем рабочую директорию
WORKDIR /var/www/html

# Устанавливаем composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
