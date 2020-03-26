FROM php:7.4.4-cli

LABEL maintainer="Denis Badulin"

# Install php extentions

RUN docker-php-ext-install pdo_mysql

# Configure php

RUN rm /usr/local/etc/php/php.*
COPY .docker/server/config/php/php.ini /usr/local/etc/php/php.ini
RUN mkdir -p /var/log/php/ && touch /var/log/php/error.log

# Install symfony binary

RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony/bin/symfony /usr/local/bin/symfony \
    && rm -rf /root/.symfony/

WORKDIR /app

CMD ["symfony", "server:start"]

