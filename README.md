# Sistema Administrador de Practicantes

* Alvaro Castro
* Ignacio Murillo
* Josué Vargas
* Luis Pablo Monge

# Pasos para installar el ambiente:

Nota: Estos pasos funciónan en linux, es posible instalar en windows con xamp.

1. Instalar laravel: https://laravel.com/docs/5.8/installation
2. Generar las llaves `php artisan key:generate`
3. Copiar `.env.tmp` a `.env` y cambiar la configuración de la base y correr `php artisan config:cache`
4. `composer install`
5. `php artisan passport:keys`
6. `php artisan migrate:fresh --seed`
