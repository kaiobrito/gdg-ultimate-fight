## Setup

- Run `cp .env.example .env`
- Start the containers with `docker-compose up -d`
- Download composer dependencies (run and go grab some coffee):
    - On Linux: `docker-compose run -u $(id -u) --rm app composer install -n --prefer-dist`
    - Any other OS: `docker-compose run --rm app composer install -n --prefer-dist`
- Run the migrations with `docker-compose run --rm app php artisan migrate --seed`
- Install Laravel  Passport `docker-compose run --rm app php artisan passport:install`
- Boot the failed container instances again (they needed the `vendor/` folder): `docker-compose up -d`

Done.
