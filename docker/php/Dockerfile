ARG PHP_VERSION

FROM php:$PHP_VERSION-fpm
ARG BASE_VERSION=8.1
RUN echo 'deb [trusted=yes] https://repo.symfony.com/apt/ /' | tee /etc/apt/sources.list.d/symfony-cli.list
RUN apt-get update -y && apt-get upgrade -y

RUN echo "**** Installation package initiaux ****"
RUN apt-get install -y --no-install-recommends \
    curl\
    gnupg\
    vim \
    git \
    wget \
    zip \
    symfony-cli \
    ca-certificates \
    apt-transport-https \
    software-properties-common \
    lsb-release \
    libicu-dev \
    unzip \
    libssl-dev zlib1g-dev   netcat libxml2-dev libpq-dev libzip-dev

RUN pecl install apcu && \
    docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
    docker-php-ext-install -j$(nproc) zip opcache intl pdo_pgsql pgsql && \
    docker-php-ext-enable apcu pdo_pgsql sodium && \
    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN echo "**** Installation Composer ****"
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer
RUN chmod +x /usr/local/bin/composer

RUN echo "**** Installation NodeJS ****"
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install -y nodejs

RUN echo "**** Installation YARN ****"
RUN apt-get install -y yarn

ADD ./docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint
ENTRYPOINT ["/usr/local/bin/docker-entrypoint"]

COPY . /srv/mact

WORKDIR /srv/mact

EXPOSE 9000

CMD ["php-fpm"]
