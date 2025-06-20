FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

RUN ln -sf /usr/local/bin/php /usr/bin/php && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --version=2.6.6 --filename=composer

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

ARG USER_ID=1000
ARG GROUP_ID=1000

RUN userdel -f www-data \
    && if getent group www-data ; then groupdel www-data; fi \
    && groupadd -g ${GROUP_ID} www-data \
    && useradd -l -u ${USER_ID} -g www-data www-data && echo "www-data:www-data" | chpasswd && adduser www-data sudo \
    && install -d -m 0755 -o www-data -g www-data /home/www-data

RUN echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers

RUN chown --changes --silent --no-dereference --recursive ${USER_ID}:${GROUP_ID}  \
    /home/www-data  \
    /var/run/php-fpm \
    /var/lib/php/sessions \
    /var/log \
    /var/www || true

USER www-data

WORKDIR /var/www/review-system