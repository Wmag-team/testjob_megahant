## Full instructions on how to install and run the latest laravel on docker containers + redis + postgres

Just follow this instruction and have a fun with developing software :)

### Installation with explanations:

1. Download this git repository to your PC by command:
`git clone git@github.com:Wmag-team/docker_laravel_nginx_postgres_redis_localhost.git`
2. Go to "docker" folder and execute command: 
`cd docker && docker-compose up -d --build && cd ..`
3. Next, go inside docker container "laravel_app" make install last Laravel by composer and exit from container: 
```
docker exec -it laravel_app bash
composer create-project --prefer-dist laravel/laravel .
exit
```
6. Compare file './laravel_snippets/composer.json' and add, what needed in './laravel/composer.json' 
7. Compare file './laravel_snippets/.env' and add, what needed in './laravel/.env'
8. Go back inside "laravel_app" container and make next command:
```
docker exec -it laravel_app bash
composer u
chmod -R 777 storage bootstrap/cache
php artisan migrate
php artisan optimize:clear
php artisan route:cache
php artisan route:clear
php artisan event:cache
php artisan event:clear
php artisan config:cache
php artisan config:clear
php artisan view:cache
php artisan view:clear

```



----------------------

### Installation commands only:

```
git clone git@github.com:Wmag-team/docker_laravel_nginx_postgres_redis_localhost.git
cd docker && docker-compose up -d --build && cd ..
docker exec -it laravel_app bash
composer create-project --prefer-dist laravel/laravel .
exit
```

... some manual work here with files: composer.json & .env ...

```
docker exec -it laravel_app bash
composer u
chmod -R 777 storage bootstrap/cache
php artisan migrate
php artisan optimize:clear
php artisan route:cache
php artisan route:clear
php artisan event:cache
php artisan event:clear
php artisan config:cache
php artisan config:clear
php artisan view:cache
php artisan view:clear
```