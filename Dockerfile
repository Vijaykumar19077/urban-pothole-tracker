FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN groupadd -g 1000 render-secrets && usermod -a -G render-secrets www-data

RUN a2enmod rewrite headers

COPY docker/apache-security.conf /etc/apache2/conf-available/app-security.conf
RUN a2enconf app-security

RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY docker/php-custom.ini "$PHP_INI_DIR/conf.d/zz-app.ini"

COPY . /var/www/html/urban-pothole-tracker/

RUN printf '%s\n' '<?php' 'header("Location: /urban-pothole-tracker/");' 'exit;' > /var/www/html/index.php

RUN mkdir -p /var/www/html/urban-pothole-tracker/uploads \
    && chown -R www-data:www-data /var/www/html/urban-pothole-tracker

COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

EXPOSE 10000

CMD ["start.sh"]
