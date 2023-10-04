<p align="center"><a href="https://laravel.com" target="_blank">TONTINE APP</a></p>

## A propos de free project

Tontine project, est un projet de gestion des reunions.

## Comment déployer , how to deploy

- First clone the project, or download from Github and unzip
- Open the project directory from command line
- Run this command: `composer install`
- Then createa file named `.env` and copy the `.env-example` content and paste in .env
- Run this command: `php artisan key:generate`
- Create a database and coll it `freeproject` in your database manager
- Run migration by with `php artisan migrate`
- Run `php artisan db:seed` to create seeders data in your database
- Run commande: `npm install & npm run dev`
- Then Run the `php artisan serve commande` to launch the app
# End doc
