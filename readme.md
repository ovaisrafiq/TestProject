Download Symfony setup form Symfony website
Download composer

setup virutal host
Xampp with PHP 7.3 support

Virtual host example

<VirtualHost *:80>
    DocumentRoot "E:/xampp/htdocs/test_project/public"
    ServerName http://symfony.local
    ServerAlias http://symfony.local
    RewriteEngine On
    RewriteCond %{HTTP:Authorization} ^(.*)
    RewriteRule .* - [e=HTTP_AUTHORIZATION:%1]
    <Directory "E:/xampp/htdocs/test_project/public">
        Order allow,deny
        Allow from all
        </Directory>
</VirtualHost>


run composer install to install all dependencies

commands

$ php bin/console make:migration

$ php bin/console doctrine:schema:update --force

$ php bin/console cache:clear --dev

$ php bin/phpunit -> to run test cases

import postman collection to run those api urls

