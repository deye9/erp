FROM phpdockerio/php71-fpm:latest

WORKDIR "/application"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install dependencies
RUN apt-get update \
    && apt-get -y --no-install-recommends install php7.1-pgsql php-redis php7.1-bcmath php7.1-gd php7.1-gmp php-igbinary php7.1-imap php-imagick php7.1-intl php7.1-phpdbg php-xhprof php-xdebug \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install git and clear cache
RUN apt-get update \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
