FROM phpdockerio/php80-fpm:latest
ARG XDEBUG_PORT
ARG USER_UID
WORKDIR "/var/www"
VOLUME /var/www/

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install bash-completion ssh iproute2 iputils-ping mc wget nano php8.0-curl php8.0-pgsql php8.0-pdo-mysql php8.0-redis php8.0-xdebug php8.0-bcmath php8.0-gd php8.0-imagick php8.0-intl php8.0-soap

# Install git
RUN apt-get update \
    && apt-get -y --no-install-recommends install git \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN touch /run/php-fpm.pid \
    && useradd -d /home/dockeruser -u $USER_UID -ms /bin/bash dockeruser \
    && chown $USER_UID:$USER_UID /run/php-fpm.pid
#RUN usermod -u $USER_UID www-data \
#    && groupmod -g $USER_UID www-data \
#    && usermod -s /bin/bash www-data

COPY . /var/www

#
#RUN chmod -R 777 /var/www/storage/ /var/www/bootstrap/cache

RUN phpenmod php-ini-config \
    && phpenmod xdebug-docker

EXPOSE $XDEBUG_PORT

#USER "dockeruser:dockeruser"
