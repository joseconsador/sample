FROM composer:latest as composer
WORKDIR /tmp
COPY ["composer.json", "composer.lock", "./"]

COPY vendor vendor
COPY database database
RUN composer install --prefer-dist --no-interaction --no-scripts

# Install yarn install requirements
FROM node:7.10.0-alpine as node
WORKDIR /tmp
RUN apk update && apk add build-base python g++ make libpng-dev
RUN apk add --no-cache --update make gcc g++ libc-dev libpng-dev automake autoconf libtool
RUN rm -rf /var/cache/apk/*

COPY ["package.json", "yarn.lock", "./"]
RUN yarn install

COPY resources resources

FROM php:7.2-fpm-alpine
ENV DEBIAN_FRONTEND noninteractive

# Install supervisor
RUN apk update && apk add supervisor && mkdir -p /var/log/supervisor && mkdir -p /etc/supervisor/conf.d
COPY ["docker/supervisor/nginx.ini", "docker/supervisor/php-fpm.ini", "/etc/supervisor.d/"]

RUN mkdir -p /run/php && touch /run/php/php7.2-fpm.sock && touch /run/php/php7.2-fpm.pid

# Enable sockets
RUN docker-php-ext-install sockets

# Install nginx as a service
RUN apk add nginx && apk add rsync
COPY docker/nginx/development.conf /etc/nginx/conf.d/web.conf
RUN mkdir -p /run/nginx

RUN mkdir /app
WORKDIR /app

# Get vendor and composer (for dump autoload later)
COPY --from=composer /tmp/vendor vendor
COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY database database
COPY ["composer.json", "composer.lock", "./"]

# Add Laravel components
COPY artisan artisan
COPY bootstrap bootstrap
COPY storage storage

# Add configurations
COPY config config

# Add application code last since they change the most often
COPY public public

COPY resources resources
COPY app app
COPY routes routes

# Optimize the Laravel class loader
RUN sed -i 's/user = www-data/user = nginx/g' /usr/local/etc/php-fpm.d/www.conf && sed -i 's/group = www-data/group = nginx/g' /usr/local/etc/php-fpm.d/www.conf

# Do autoload, optimize and update ownership
RUN composer dump-autoload && chown -R nginx:nginx /app

EXPOSE 6080
CMD ["supervisord", "-n"]