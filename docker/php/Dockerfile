ARG PHP_VERSION

FROM php:$PHP_VERSION-fpm
ARG BASE_VERSION=8.2.23
RUN echo 'deb [trusted=yes] https://repo.symfony.com/apt/ /' | tee /etc/apt/sources.list.d/symfony-cli.list
RUN apt-get update -y && apt-get upgrade -y

RUN echo "**** Installation package initiaux ****"
RUN apt-get install -y --no-install-recommends \
    apt-transport-https \
    ca-certificates \
    curl\
    git \
    gnupg\
    libicu-dev \
    libpq-dev  \
    libssl-dev  \
    libxml2-dev  \
    libzip-dev \
    lsb-release \
    netcat-traditional \
    software-properties-common \
    symfony-cli \
    unzip \
    vim \
    wget \
    zip \
    zlib1g-dev \
    zsh \
    && apt-get clean

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
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - && \
    echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list && \
    apt update && \
    apt install yarn

RUN sh -c "$(wget https://raw.github.com/ohmyzsh/ohmyzsh/master/tools/install.sh -O -)" && \
    echo 'alias sf="php bin/console"' >> ~/.zshrc && \
    echo 'alias ll="ls -als"' >> ~/.zshrc \

RUN chsh -s /bin/zsh

COPY ./docker-entrypoint.sh /usr/local/bin/docker-entrypoint

RUN chmod +x /usr/local/bin/docker-entrypoint
ENTRYPOINT ["/usr/local/bin/docker-entrypoint"]

COPY . /srv/mact

WORKDIR /srv/mact

EXPOSE 9000

CMD ["php-fpm"]
