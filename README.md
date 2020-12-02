<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Vi-test project yii2+vue.js</h1>
    <br>
</p>

Проект на основе Advanced шблона Yii2.
В иректории `./frontend` vue.js приложение.


## Установка с Docker

1. Настройка хостов:

    Открываем файл хостов в общем случае *nix системм: `/etc/host`. Добавляем хосты:

    ```json
    127.0.0.1   docker-vi-test.loc
    127.0.0.1   api.docker-vi-test.loc
    ```

2. Клонирование репозитория:

    `git clone git@github.com:EvgenyVetrov/vi-test.git vi-test`

3. Инициализация

    Так как докер связан через volumes с проектом, можно начальную инициализацию провести тут:
    
    ```
    cd vi-test
    composer install
    ```
    
    Далее `php init` c dev окружением. Прод окружение не настроено, да и не думал где именно прод будет.
    
4. Запуск докера:

    `docker-compose up`
    
    Если Инициализацию не сделать из системы, можно попробовать сделать из докера:
    
    ```
    sudo docker exec -it vitest_app_1 /bin/bash
    cd /var/www/app
    composer install
    php init
    ```
    
5. Запуск миграций
    
    внутри докер контейнера выполнить миграции:
    ```
    sudo docker exec -it vitest_app_1 /bin/bash
    cd /var/www/app
    php yii migrate
    ```

6. Можно пробовать в браузере перейти на docker-vi-test.loc

Т.к. в контейнере свой nginx есть, нужно остановить встроенный nginx (если он вообще был)
`sudo service nginx stop`

  
  <br>
  <br>

## Установка в систему без контейнеров:

1, 2, 3 пункты повторить.

## БД

Должна работать БД и быть доступна по localhost-у.
нужно создать пустую базу `vi-test` в кодировке `utf8mb4_general_ci`

Прописать данные от БД тут:
`./common/config/main-local.php`

Выполнить миграции: `php yii migrate`


### Конфигурация NGINX

Создаем файл конфигурации в /etc/nginx/sites-available/vi-test.loc


```
# фронтовая часть
server {
    listen          80;
    server_name     docker-vi-test.loc;
    charset         utf-8;
    root    /home/evetrov/projects/vi-test/frontend/dist;
    index   index.html index.htm;
    # Always serve index.html for any request
    location / {
        root    /home/evetrov/projects/vi-test/frontend/dist;
        try_files $uri /index.html;
    }
}



# API
server {
    listen 80;
    listen [::]:80;

    set $cors "";
    if ($http_origin ~* (\.docker-vi-test\.loc|\.evetrov\.ru)) {
        set $cors "true";
    }
    #if ($http_origin ~^ (192\.168\.)) {
    #    set $cors "true";
    #}
    add_header 'Access-Control-Allow-Methods' 'GET, POST, PUT, OPTIONS';
    add_header 'Access-Control-Allow-Origin' "$http_origin";

    charset          utf-8;
    index            index.php;
    server_name      api.vi-test.loc;
    root             /home/evetrov/projects/vi-test/api/web;
    location / {
        rewrite ^(.*)$ /index.php;
    }

    location ~* ^.+\.(js|css|svg|jpeg|gif|jpg|png|svg|html|json|ttf|woff|woff2|mp3)$ {
        access_log off;
        expires 8d;
        add_header "Vary" "Accept-Encoding";
    }

    location ~ \.php$ {
            include snippets/fastcgi-php.conf;
            fastcgi_pass unix:/var/run/php/php7.2-fpm.sock;
            #fastcgi_pass 127.0.0.1:9000;
            #fastcgi_read_timeout 30000;
    }
}
```

Прошу обратить внимание на некоторые отличия NGINX конфига для docker и для встроенного NGINX

Делаем ссылку на файл в `/etc/nginx/sites-enabled` (для nginx в linux):

`sudo ln -s /etc/nginx/sites-available/vi-test.loc /etc/nginx/sites-enabled/vi-test.loc`

Перезапускаем NGINX: `service nginx restart`

Либо перезагружаем конфиги: `sudo nginx -s reload` в случае если были правки в конфиге, а не полностью новый файл конфига.

Далее можно пробовать.