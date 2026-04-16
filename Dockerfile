FROM php:8.4-apache

# 1. Install system dependencies (including Postgres drivers)
RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    curl

# 2. Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql

# 3. Enable Apache mod_rewrite for Laravel routing
RUN a2enmod rewrite

# 4. Change Apache document root to Laravel's /public folder
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/conf-available/*.conf

# 5. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 6. Install Bun
RUN curl -fsSL https://bun.sh/install | bash
ENV PATH="/root/.bun/bin:${PATH}"

# 7. Set working directory
WORKDIR /var/www/html

# 8. Copy your application code
COPY . .

# 9. Install dependencies and build assets
RUN composer install --no-dev --optimize-autoloader
RUN bun install
RUN bun run build

# 10. Set correct permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 11. Configure Apache to listen on Render's required port
RUN sed -i 's/Listen 80/Listen ${PORT}/g' /etc/apache2/ports.conf
RUN sed -i 's/:80/:${PORT}/g' /etc/apache2/sites-available/000-default.conf

# 12. Run migrations and start the server
CMD php artisan migrate --force && apache2-foreground
