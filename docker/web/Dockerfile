FROM ubuntu:14.04

# Install Requirements
RUN apt-get update -qq && apt-get install -qqy \
    sudo \
    wget \
    curl \
    git \
    apt-utils \
    acl

RUN echo "Europe/Paris" > /etc/timezone && dpkg-reconfigure -f noninteractive tzdata

# Repository PHP 5.6
RUN apt-get update -qq && apt-get install -qqy \
    software-properties-common \
    python-software-properties
RUN add-apt-repository ppa:ondrej/php5-5.6

# PHP
RUN apt-get update -qq && apt-get install -qqy --force-yes \
    php5 \
    php-apc \
    php5-cli \
    php5-xdebug \
    php5-intl \
    php5-mysql \
    php5-curl \
    php5-gd \
    php5-mongo \
    php5-redis \
    php5-fpm

# Nginx
RUN \
    add-apt-repository -y ppa:nginx/stable && \
    apt-get update && \
    apt-get install -y nginx && \
    rm -rf /var/lib/apt/lists/* && \
    echo "\ndaemon off;" >> /etc/nginx/nginx.conf && \
    chown -R www-data:www-data /var/lib/nginx

# Config Nginx
ADD conf/nginx/dev /etc/nginx/sites-available/web
RUN rm -f /etc/nginx/sites-enabled/default && \
    rm -f /etc/nginx/sites-available/default && \
    rm -rf /var/www/html && \
    ln -s /etc/nginx/sites-available/web /etc/nginx/sites-enabled/web

# Config PHP
ADD conf/php5/apc.ini /etc/php5/mods-available/apc.ini
ADD conf/php5/php.ini /tmp/php.ini
RUN cat /tmp/php.ini >> /etc/php5/fpm/php.ini && \
    cat /tmp/php.ini >> /etc/php5/cli/php.ini && \
    rm /tmp/php.ini

# Install NodeJS
RUN apt-get update -qq && apt-get install -qqy --force-yes \
    nodejs \
    npm

# Install Less with npm
RUN npm install less

# Logs
RUN mkdir -p /var/log/nginx \
    && chown -R www-data:www-data /var/log/nginx

# Alias
RUN echo "alias sf='php app/console'" >> /root/.bashrc

# Sources
WORKDIR /var/www

VOLUME ["var/log/nginx", "/var/log/nginx"]

# Expose ports
EXPOSE 80

# Default command
CMD service php5-fpm start && nginx
