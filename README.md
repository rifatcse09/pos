## Portonics POS

## Description

The task is developed by Laravel 8. Laravel Repository Pattern is used for development. Laravel Passport is used for API authentication. Frontend is developed by Vue JS SB Admin Template.In development, The task has PHPUnit test case.

### Installation

1. Clone this repo

```
git clone https://github.com/rifatcse09/pos.git
```

2. Install composer packages

```
$ cd pos
$ composer install
```

3. Create and setup .env file

```
$ copy .env.example .env
$ php artisan key:generate
put database credentials in .env file
```

5. Put currency conversion api key in .env file

```
API_KEY=YOUR_PORT_WALLET_API_KEY
API_SECRET_KEY=YOUR_PORT_WALLET_API_SECRET_KEY
```

6. Migrate and insert records

```
$ php artisan migrate
$ php artisan db:seed
```

7. Install passport

```
$ php artisan passport:install
$ php artisan passport:keys
```

8. Install dependency with NPM

```
 npm install
```

9. Develop

```
npm run dev
```

10. Run the server

```
$ php artisan serve
```

11. Use any user from user table

```
password:123456
```

12. Run phpUnit Test

```
$ ./vendor/bin/phpunit
```
