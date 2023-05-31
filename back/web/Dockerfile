FROM php:8.1-apache

ADD crontab /etc/cron.d/hello-cron

RUN chmod 0644 /etc/cron.d/hello-cron

RUN touch /var/log/cron.log

RUN apt-get update \
    && pecl install redis \
    && docker-php-ext-install mysqli \
    && docker-php-ext-enable redis \
    && a2enmod rewrite \
    && service apache2 restart \
    && apt-get -y install cron

RUN rm -rf /var/lib/apt/lists/*

CMD cron && apache2-foreground
