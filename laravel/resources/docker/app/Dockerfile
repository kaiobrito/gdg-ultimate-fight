FROM php:7.2-apache-stretch

# Install server dependencies
RUN apt-get update \
    && apt-get install -y git-core zip \
    && php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer \
    && apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-install pdo pdo_mysql pcntl bcmath

COPY . /var/www/html
COPY resources/docker/app/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY resources/docker/app/start.sh /usr/local/bin/start

RUN chown -R 1000:33 /var/www/html \
    && chmod -R ug+rw /var/www/html \
    && chown 1000:33 /usr/local/bin/start \
    && chmod u+x /usr/local/bin/start \
    && a2enmod rewrite

CMD ["/usr/local/bin/start"]
