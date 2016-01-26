Sistema Administrativo Grupo Dicotech (SAGD)
===========

> Para el setup inicial es recomendable, o mejor dicho __obligatorio__ tener una máquina virtual usando vagrant.

> Información y pasos para instalarlo puedes encontrarlo aquí: [Homestead](http://laravel.com/docs/5.1/homestead)

## Homestead

Homestead ya viene con muchas cosas instaladas como _redis_ y _nodejs_. Pero hay que instalar **PM2** para ejecutar el server de Node.js que se encarga de los _sockets_.

Para esto hay que leer [esta entrada en el wiki](https://bitbucket.org/zegucomcomputo/sagd/wiki/Preparaci%C3%B3n%20e%20instalaci%C3%B3n%20de%20server%20Node.js%20y%20Redis).

Resulta que **PM2** no inicia los servicios cuando inicia la máquina. Así que cada vez que inicias tu vm, si no la suspendiste y le diste **halt**, tendrás que iniciarlo manualmente con `pm2 start socket.js` desde la carpeta de `sagd`.

Creo que no viene con _supervisor_. Asi que a darle. Info [aquí](https://bitbucket.org/zegucomcomputo/sagd/wiki/Instalando%20Supervisor%20para%20persisitir%20el%20queue%3Aworker%20de%20Laravel).

`Supervisor` es para auto-iniciar los `queues` de la aplicación. Es como `pm2` pero en lugar de servers de node, este corre cualquier shell script o comando. En este caso es para inicar el `queue` de laravel. El wiki tiene más información de esto.

## sagd/

En la carpeta de `sagd` o de tu código, hay cosas que correr antes de empezar a usar la aplicación.

En tu termial tienes que correr estos comandos en el root de la aplicación.

```
composer install
npm install
```

Después nos cambiamos a la carpeta de `app-angular` y corremos los siguientes:

```
sudo npm install -g grunt
npm install
bower install
grunt dev
```



## `.env` file

Este archivo no esta versionado y solo será visible aquí. Hay que copiar y pegarlo localmente en tu archivo `.env`. Si no existe, crealo.

> Cualquier cambio futuro a las variables de env se tienen que comentar con el equipo y anotar aqui abajo.

```
APP_ENV=local
APP_DEBUG=true
APP_KEY=anK2OwTLR0C4w2SgePIj7qTjaPMKx8dt
BROADCAST_DRIVER=redis

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
DB_PASSWORD_LEGACY=dicodev2015

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_DRIVER=sync

MAIL_DRIVER=log
MAIL_HOST=www.zegucom.com.mx
MAIL_PORT=995
MAIL_USERNAME=mgomez@zegucom.com.mx
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
FRONTEND_URL="http://sagd.app/password/reset/"
CDN_URL="http://cdn.sagd.app/"

ICECAT_USERNAME=jlopez
ICECAT_PASSWORD=zegucom123

STUB_EMAIL_DOMAIN=clientes.grupodicotech.com.mx

RESOURCE_PAGINATION=15

TOKEN_TTL=20160


```

## Set-up de la base de datos

Hay un archivo `create_schemas_users_permissions.sql`. Que contiene lo siguiente:

```
CREATE SCHEMA `sagd_local` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
CREATE USER 'sagd_local'@'localhost' IDENTIFIED BY 'zegucomlocal';
GRANT ALL ON sagd_local.* TO 'sagd_local'@'localhost';

CREATE SCHEMA `sagd_test` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
CREATE USER 'sagd_test'@'localhost' IDENTIFIED BY 'zegucomtest';
GRANT ALL ON sagd_test.* TO 'sagd_test'@'localhost';

CREATE SCHEMA `sagd_prod` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
CREATE USER 'sagd_prod'@'localhost' IDENTIFIED BY 'zegucomprod';
GRANT ALL ON sagd_prod.* TO 'sagd_prod'@'localhost';

```

Esto hay que ejecutarlo en la base de datos de nuestra máquina virtual de Homestead.

Después de esto ya podemos iniciar la base de datos con las migraciones y datos iniciales.

Para eso se ejecutan los siguientes comandos:

```
php artisan migrate
php artisan db:seed
```

Para evitar seedear los módulos completos de `Clientes` se puede generar un dump y colocarlo en
la carpeta raíz del proyecto. Nombrar este archivo `clientes_module_seed.sql`.

Si ya seedeaste los clientes crea el dump de las tablas de:

- `clientes`
- `clientes_autorizaciones`
- `clientes_comentarios`
- `domicilios`
- `domicilios_clientes`
- `paginas_web_distribuidores`
- `tabuladores`
- `telefonos`
- `users`

En la tabla de `domicilios` se tienen que quitar los primeros 6 domicilios manualmente, es decir, editar a mano el dump.

La siguiente vez que realices el seed, tomará este archivo y lo importará en lugar de seedear normalmente.
Esto agiliza el seeding.


Para `testing` y poder correr las pruebas son los siguientes comandos:

```
php artisan migrate --env=testing
php artisan db:seed --env=testing
```
