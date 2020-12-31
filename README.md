## Projeto 18

git clone https://github.com/joaocarias/project-18.git 

composer install

npm install

cp .env.example .env

php artisan key:generate

configurar db em .env

php artisan migrate

php artisan db:seed

vendor\laravel\framework\src\Illuminate\Foundation\Auth\AuthenticatesUsers.php

composer require doctrine/dbal
