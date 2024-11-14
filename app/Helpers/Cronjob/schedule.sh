#!/bin/bash

echo 'force stop schedule...'

pkill -f 'php artisan schedule:work' | grep '/www/wwwroot/short-url.tple008.my.id'

sleep 3

echo 'schedule start...' 

cd /www/wwwroot/short-url.tple008.my.id
/www/server/php/83/bin/php artisan schedule:work &

wait