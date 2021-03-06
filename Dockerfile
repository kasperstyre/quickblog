# Build frontend assets
FROM node:current-alpine as frontend-compile
WORKDIR /build
COPY . /build
RUN npm install
RUN npm run dev

FROM php:7.4-fpm as backend-compile

# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl
RUN docker-php-ext-configure gd
RUN docker-php-ext-install gd

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY --from=frontend-compile /build /var/www

# Copy existing application directory permissions
COPY --from=frontend-compile --chown=www:www /build /var/www

# Install PHP dependencies
RUN composer install

# Change current user to www
USER www

COPY ./docker/start.sh /
COPY --chown=www:www ./docker/start.sh /

# Expose port 9000 and start php-fpm server
EXPOSE 9000
ENTRYPOINT ["/start.sh"]