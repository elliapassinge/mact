#!/bin/sh
set -e
# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
    set -- php-fpm "$@"
fi

if [ "$INSTALL" = true ]; then
    echo "*********** INSTALL = true *******************"
    echo "*********** COMPOSER *******************"
    composer install --prefer-dist --no-interaction --no-scripts
    php vendor/phpro/grumphp/bin/grumphp git:init
    echo "*********** YARN && ENCORE *******************"
    yarn install
    yarn encore dev
    echo "*********** CREATE DIRS *******************"
    mkdir -p /srv/mact/var
    mkdir -p /srv/mact/public/upload/pictures
    echo "*********** MAPPING WWW-DATA *******************"
    ## Remapping generate folders to match user id when volume is mounted
    if [ "$(id -u www-data)" = "82" ]; then
        deluser --remove-home www-data &&\
        adduser -u "${USER_ID}" -D www-data -s /bin/sh
        chown -h -R "${USER_ID}":"${USER_ID}" \
        /srv/mact/var \
        /srv/mact/public \
        /srv/mact/data \
        /srv/mact/vendor \
        /srv/mact/node_modules
    fi
else
    echo "*********** INSTALL = false *******************"
fi

echo "*********** XDEBUG ENABLED *******************"
cp ./docker/php/config/php.dev.xdebug.ini "${PHP_INI_DIR}"/conf.d/zz-custom-dev-xdebug-eliberty-php.ini
echo "zend_extension=xdebug" > "${PHP_INI_DIR}"/conf.d/docker-php-ext-xdebug.ini

exec "$@"
