# IFDD Services

New Services IFDD

## Installation

```sh
$ git clone https://github.com/GeOsmFamily/ifdd-services.git
$ cd ifdd-services
$ cp .env.example .env
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

```

-   edit & add Docker config in .env

```
APP_PORT=
FORWARD_DB_PORT=
PG_PASSWORD=
```

```
$ docker-compose up -d
$ docker exec -it ifdd-services bash
$ composer install
```

```
$ php artisan key:generate
$ php artisan migrate
$ php artisan passport:install
$ php artisan db:seed
$ php artisan apikey:generate app1
$ php artisan storage:link
$ php artisan scribe:generate
$ exit
```

-   Add authorization in docker

```
go to services folder
$ chown -R www-data:www-data *
```

## Documentation

### Allowed verbs

`GET`, `POST`, `PUT`, `PATCH` ou `DELETE`

### Required in the header of all requests

```
Content-Type: application/json
Accept: application/json
X-Authorization : yourApiKey
```

-   Documentation Link : https://prrojectUrl/docs
