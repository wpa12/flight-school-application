# Bristol Flight School System

## Introduction

This is a laravel project and uses mailpit and telescope

clone the project and run the following:

```bash
cd [path to project]
composer install
npm run install

cp .env.example .env

php artisan key:generate
sail up -d
sail artisan migrate
sail artisan db:seed
```
Admin user credentials

`email - admin@example.com`
`password - password`


you can access a user from the database by getting their email address
passwords for all users is `password`

Mailpit is accessible at to view notifications - be sure to run the queue worker `sail artisan queue:work`

```
http://localhost:8025
```

Telescope for viewing run jobs and exceptions

```
http://localhost/telescope
```

## Tests

There are a few tests I've added, the tests suites are not fully complete but the once i've added can be run with

`sail artisan test`
