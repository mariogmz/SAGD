## Current `.env` file
```
APP_ENV=local
APP_DEBUG=true
APP_KEY=anK2OwTLR0C4w2SgePIj7qTjaPMKx8dt

DB_HOST=localhost
DB_DATABASE=sagd_local
DB_USERNAME=sagd_local
DB_PASSWORD=zegucomlocal

TEST_DB_HOST=localhost
TEST_DB_DATABASE=sagd_test
TEST_DB_USERNAME=sagd_test
TEST_DB_PASSWORD=zegucomtest

DB_HOST_LEGACY=server.grupodicotech.com.mx
DB_DATABASE_LEGACY=sazcentralizado
DB_USERNAME_LEGACY=development
DB_PASSWORD_LEGACY=test123!

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

MAIL_DRIVER=smtp
MAIL_HOST=mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null

```

## Correr estos queries
```
CREATE SCHEMA `sagd_local` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
CREATE USER 'sagd_local'@'localhost' IDENTIFIED BY 'zegucomlocal';
GRANT ALL ON sagd_local.* TO 'sagd_local'@'localhost';

CREATE SCHEMA `sagd_test` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
CREATE USER 'sagd_test'@'localhost' IDENTIFIED BY 'zegucomtest';
GRANT ALL ON sagd_test.* TO 'sagd_test'@'localhost';
```


## Laravel PHP Framework

[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/d/total.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as authentication, routing, sessions, queueing, and caching.

Laravel is accessible, yet powerful, providing powerful tools needed for large, robust applications. A superb inversion of control container, expressive migration system, and tightly integrated unit testing support give you the tools you need to build any application with which you are tasked.

## Official Documentation

Documentation for the framework can be found on the [Laravel website](http://laravel.com/docs).

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

### License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)