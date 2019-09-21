FROM phpdockerio/php72-fpm:latest

WORKDIR "/application"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install dependencies
RUN apt-get update && apt-get -y --no-install-recommends install \
    php7.2-pgsql \
    php-redis \
    php7.2-bcmath \
    php7.2-gd \
    php7.2-gmp \
    php-igbinary \
    php7.2-imap \
    php-imagick \
    php7.2-intl \
    php7.2-phpdbg \
    php-xhprof \
    php-xdebug \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# install redis and xdebug php extension
# RUN docker-php-ext-enable redis xdebug
RUN echo "error_reporting = E_ALL" >> /etc/php/7.2/mods-available/xdebug.ini
RUN echo "display_startup_errors=On" >> /etc/php/7.2/mods-available/xdebug.ini
RUN echo "display_errors=On" >> /etc/php/7.2/mods-available/xdebug.ini
RUN echo "xdebug.remote_enable=on" >> /etc/php/7.2/mods-available/xdebug.ini
RUN echo "xdebug.remote_connect_back=0" >> /etc/php/7.2/mods-available/xdebug.ini
RUN echo "xdebug.remote_autostart=off" >> /etc/php/7.2/mods-available/xdebug.ini
RUN echo "xdebug.remote_handler=dbgp" >> /etc/php/7.2/mods-available/xdebug.ini
RUN echo "xdebug.remote_host=docker.for.mac.localhost" >> /etc/php/7.2/mods-available/xdebug.ini
RUN echo "xdebug.idekey=vscode" >> /etc/php/7.2/mods-available/xdebug.ini
RUN echo "xdebug.remote_port=9001" >> /etc/php/7.2/mods-available/xdebug.ini

EXPOSE 9001
