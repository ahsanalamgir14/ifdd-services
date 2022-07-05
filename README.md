# IFDD Services

New Services IFDD

## Installation

```sh
$ git clone https://github.com/GeOsmFamily/ifdd-services.git
```

-   edit & add DB & Email infos in .env

```
DB_DATABASE=database name
DB_USERNAME=database username
DB_PASSWORD=database password

MAIL_MAILER=smtp
MAIL_HOST=your host
MAIL_PORT=your port
MAIL_USERNAME=your username
MAIL_PASSWORD=your password
MAIL_ENCRYPTION=TLS
MAIL_FROM_ADDRESS=infos@ifdd.com
MAIL_FROM_NAME=IFDD


APP_FRONTEND=url_to_frontend

MEILISEARCH_HOST=host

```

```
$ php artisan key:generate
$ php artisan migrate
$ php artisan passport:install
$ php artisan db:seed
$ php artisan apikey:generate demo
$ php artisan storage:link
$ php artisan scribe:generate
```
