FROM php:8.3-apache

RUN docker-php-ext-install mysqli \
    && mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

WORKDIR /var/www/html
COPY . .

ENV MEESHOP_DEMO_READ_ONLY=true

CMD ["sh", "-c", "port=${PORT:-8080}; sed -i \"s/Listen 80/Listen $port/\" /etc/apache2/ports.conf; sed -i \"s/*:80/*:$port/\" /etc/apache2/sites-available/000-default.conf; exec apache2-foreground"]
