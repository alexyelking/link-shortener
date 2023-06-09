FROM php:8.1-apache

ADD crontab /etc/cron.d/hello-cron

RUN chmod 0644 /etc/cron.d/hello-cron

RUN touch /var/log/cron.log

RUN apt-get update \
    && docker-php-ext-install mysqli \
    && apt-get -y install cron

CMD cron && tail -f /var/log/cron.log
