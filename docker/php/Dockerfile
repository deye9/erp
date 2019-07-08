FROM phpdockerio/php72-fpm:latest

WORKDIR "/application"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install dependencies
RUN apt-get update \
    && apt-get -y --no-install-recommends install php7.2-pgsql php-redis php7.2-bcmath php7.2-gd php7.2-gmp php-igbinary php7.2-imap php-imagick php7.2-intl php7.2-phpdbg php-xhprof php-xdebug \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install git and clear cache
RUN apt-get update \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
