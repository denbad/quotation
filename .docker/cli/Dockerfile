FROM php:7.4.4-cli

LABEL maintainer="Denis Badulin"

# Install php extentions

RUN docker-php-ext-install pdo_mysql

# Configure php

RUN rm /usr/local/etc/php/php.*
COPY .docker/cli/config/php/php.ini /usr/local/etc/php/php.ini
RUN mkdir -p /var/log/php/ && touch /var/log/php/error.log

# Install composer

COPY .docker/cli/config/composer/composer-installer.sh /usr/local/bin/composer-installer

RUN apt-get -yqq update \
    && apt-get -yqq install --no-install-recommends unzip \
    && chmod +x /usr/local/bin/composer-installer \
    && composer-installer \
    && mv composer.phar /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer \
    && composer --version

# Install git

RUN apt-get install -y git

# Install symfony binary

RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony/bin/symfony /usr/local/bin/symfony \
    && rm -rf /root/.symfony/

WORKDIR /app

# Listen

CMD ["tail", "-f", "/var/log/php/error.log"]
