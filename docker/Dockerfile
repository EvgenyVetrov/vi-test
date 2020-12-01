# Базовый образ с nginx и php
FROM richarvey/nginx-php-fpm:1.10.2

# Добавляем наше веб приложение
COPY . /var/www/app

# Удаляем конфиги сайтов которые там есть
RUN rm -Rf /etc/nginx/sites-enabled/*

# Добавляем наш конфиг
COPY docker/nginx/conf.d/site.conf /etc/nginx/sites-available/site.conf

# Включаем его
RUN ln -s /etc/nginx/sites-available/site.conf /etc/nginx/sites-enabled/site.conf