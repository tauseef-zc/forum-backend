FROM php:8.0.25-fpm

WORKDIR /var/www

# Enable a2enmod
#RUN a2enmod rewrite

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    vim \
    nano \
    zip \
    unzip \
    mariadb-client --no-install-recommends

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install php extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip mysqli

# Install Node for front end
RUN apt-get update && apt-get install -y \
    software-properties-common \
    npm yarn

RUN npm install npm@latest -g && \
    npm install n -g && \
    n latest

# Setup composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer