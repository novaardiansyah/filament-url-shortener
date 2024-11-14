#!/bin/bash

echo 'force stop queue...'

pkill -f 'php artisan queue:work' | grep '/www/wwwroot/short-url.tple008.my.id'

sleep 3

cd /www/wwwroot/short-url.tple008.my.id

echo '--queue=portfolio restart...'
/www/server/php/83/bin/php artisan queue:restart

echo 'queue start...' 
/www/server/php/83/bin/php artisan queue:work &

wait