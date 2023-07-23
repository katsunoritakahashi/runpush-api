FROM php:7.4.14-fpm-alpine3.12

RUN apk update

# timezone
RUN apk --no-cache add tzdata linux-headers zlib-dev icu-dev autoconf make g++ gcc \
    && cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime \
    && apk del tzdata

# php extension
RUN docker-php-ext-install bcmath pdo_mysql
RUN pecl install grpc
RUN docker-php-ext-enable grpc

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.0.13

# iconv
# see https://github.com/docker-library/php/issues/240
# see https://github.com/exozet/docker-php-fpm/pull/136
RUN apk --no-cache add gnu-libiconv
ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so php

# for gd
RUN apk add --no-cache freetype libpng libjpeg-turbo freetype-dev libpng-dev libjpeg-turbo-dev
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

COPY ./docker/php/php.ini /usr/local/etc/php/php.ini
COPY ./backend /work
WORKDIR /work

RUN find ./storage -type d -exec chmod 777 {} \;
RUN find ./storage -type f -exec chmod 664 {} \;
RUN find ./bootstrap/cache -type d -exec chmod 777 {} \;
RUN find ./bootstrap/cache -type f -exec chmod 664 {} \;
RUN rm -rf ./bootstrap/cache/*
RUN rm -rf ./storage/framework/cache/*
RUN rm -rf ./storage/framework/sessions/*
RUN rm -rf ./storage/framework/testing/*
RUN rm -rf ./storage/framework/views/*
RUN rm -rf ./storage/logs/*
RUN cp .env.stg .env

RUN composer install

CMD ["php-fpm", "--nodaemonize"]