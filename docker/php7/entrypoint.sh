# /bin/sh
composer install --no-dev --optimize-autoloader
php bin/console doctrine:database:drop
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
php bin/console data:load-geo-data

yarn
yarn run prod

php-fpm