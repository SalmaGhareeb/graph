FROM php:7.2-alpine
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install mysqli
RUN apk add --update --no-cache \
libcurl \
curl \
make \
bash
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR  /var/www
COPY .  /var/www
