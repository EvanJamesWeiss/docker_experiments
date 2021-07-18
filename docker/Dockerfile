FROM php:7.4-fpm-alpine3.13

RUN apk update && apk upgrade \
&& apk add git \
&& apk add supervisor nginx libxml2-dev

RUN curl --insecure https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer

RUN docker-php-ext-install soap pdo_mysql

EXPOSE 9000
CMD ["php-fpm"]