FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN usermod -a -G 1000 www-data

RUN a2enmod rewrite headers

COPY docker/apache-security.conf /etc/apache2/conf-available/app-security.conf
RUN a2enconf app-security

RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY docker/php-custom.ini "$PHP_INI_DIR/conf.d/zz-app.ini"

COPY . /var/www/html/urban-pothole-tracker/

RUN mkdir -p /var/www/html/urban-pothole-tracker/uploads \
    && chown -R www-data:www-data /var/www/html/urban-pothole-tracker

COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

EXPOSE 10000

CMD ["start.sh"]
