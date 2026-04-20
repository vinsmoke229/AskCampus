FROM php:8.3-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

# Install PHP extensions (CRITICAL: MySQL driver)
RUN docker-php-ext-install pdo_mysql mbstring

# Get Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy application files
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Make start script executable
RUN chmod +x start.sh

# Expose port
EXPOSE $PORT

# Use our start script
CMD ["./start.sh"]