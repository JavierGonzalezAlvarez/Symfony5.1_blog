Blog
------------
symfony 5.1.3
php 7.4.3.
postgresql 12.4
php7.4-pgsql

Postgresql
------------
sudo su - postgres
psql
\l
\l
\c "nombre_base_datos"
\d+ "nombre_tabla"
DROP DATABASE "nombre_tabla"

Nota: en postgresql la palabra user es reservada. Al Crear la tabla "user" debe ser con un nombre en anotaciones.

Crear app
-----------
symfony new appblog --full

Inicar servidor 
---------------------
wget https://get.symfony.com/cli/installer -O - | bash
export PATH="$HOME/.symfony/bin:$PATH"
symfony server:start

Crear Base de Datos
--------------------
php bin/console doctrine:database:create

Migraciones
--------------
php bin/console make:migration
php bin/console doctrine:migrations:migrate
php bin/console doctrine:schema:update --force