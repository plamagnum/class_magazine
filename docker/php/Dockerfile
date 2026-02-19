FROM php:8.2-fpm

# Встановлення системних залежностей
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_mysql mysqli zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Налаштування робочої директорії
WORKDIR /var/www/html

# Встановлення прав доступу
RUN chown -R www-data:www-data /var/www/html
