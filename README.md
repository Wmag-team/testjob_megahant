My thought about it on youTube video (18min): https://www.youtube.com/watch?v=hQClctGqGI8

### Installation with explanations:

1. Download this git repository to your PC by command:
`git clone git@github.com:Wmag-team/git@github.com:Wmag-team/testjob_megahant.git .`
2. `cp ./laravel/.env.example ./laravel/.env`
2. Go to "docker" folder and execute command: 
`cd docker && docker-compose up -d --build && cd ..`
3. Some jobs to do to start Laravel
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
touch storage/logs/laravel.log
touch storage/logs/error.log
touch storage/logs/debug.log
sudo chmod -R 775 storage
sudo chmod -R ugo+rw storage

```


### Why do you need it ?

This repository, along with the installation instructions, is a product of intellectual labor that provides a solution for many developers (I, for my part, broke many spears before creating this universal installation package).

Its content, together with the installation instructions, resolves the installation of the following configuration in just one minute:

Laravel 11
+ Horizon (managing various queue configurations within the project)
+ Laravel Schedule (managing cron jobs through Laravel, rather than an external system cron)
+ Supervision (ensures that Horizon and Laravel Schedule processes are always running and operational)
+ Redis (cache driver necessary for Horizon)
+ PostgreSQL (by default, I use this database, but there can be various options)
+ Nginx configured for local machines
- All of this runs on any machine since each element is a Docker container, giving developers a 100% guarantee that they are developing the product in a unified software environment configuration.

This software environment package, which is well-integrated and functions as a whole without glitches or other complaints, can be installed on any PC in just a few minutes (as long as it has Docker).

I believe that for modern applications, this is the minimally necessary set of software environments that every application should include by default. This is a universal software environment package that can certainly be expanded but is unlikely to be reduced.
