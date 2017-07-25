FROM php:5.6-fpm

ADD php.ini    /usr/local/etc/php/php.ini
ADD php-fpm.conf    /usr/local/etc/php-fpm.conf

COPY redis-3.1.3.tgz /home/redis.tgz
RUN docker-php-ext-install pdo_mysql \
    && pecl install /home/redis.tgz && echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini
ADD composer.phar /usr/local/bin/composer
RUN chmod 755 /usr/local/bin/composer
RUN mkdir -p /usr/local/etc/php-fpm.d

WORKDIR /opt

VOLUME ["/opt"]
