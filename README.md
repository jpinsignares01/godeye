# godeye
God eye is an app to find people in the universe.


# Deploy - Develop
```sh
$ docker run --name godeye -v [path]/godeye:/var/www -v [path]/godeye/public:/var/www/html -p 20080-20080:80 -p 20443-20443:443 -d -it jgromero7sds/ubuntu-apache2-php7.4-laravel:v1 bash
```


# Dependencies install
```sh
$ docker exec -it ContainerID bash

# Recommended setup
$ nano /etc/php/7.4/apache2/php.ini
    post_max_size = 250M
    upload_max_filesize = 250M
    memory_limit = 4096M
    max_execution_time = 600


# Project directory
$ cd var/www

# Dependencies install
$ composer install
$ npm install && npm run dev

# Key generate
$ php artisan key:generate

# Directories permissions
$ chmod 777 bootstrap/cache
$ chmod 777 node_modules
$ chmod 777 html
$ chmod 777 public
$ chmod 777 public/css
$ chmod 777 public/js
$ chmod 777 -R storage
$ chown -R www-data\: storage bootstrap/cache
```

# Configuración Apache2
```sh
# Ejecutamos el servidor apache2
$ service apache2 start
$ a2enmod rewrite
$ service apache2 restart
```

# Apache2 setup
```sh
# Virtualhost
$ nano /etc/apache2/sites-available/000-default.conf

# Before DocumentRoot /var/www/html add the following lines
<Directory /var/www/html>
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>

$ service apache2 restart