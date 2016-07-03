# Schiphol
Script to determine which of the 6 runways on Schiphol Airport are used
for starting or landing and notify using prowl if a change is detected

## Installation
 use composer: https://getcomposer.org/download/
 clone project
 php composer.phar install

## Cron configuration on raspberry pi
 # m h  dom mon dow   command
 * * * * * /usr/bin/php /var/www/html/schiphol/index.php

## Prowl
 Prowl https://www.prowlapp.com/ is a paid service to deliver push notifications to your iPhone.
 The api is extremely simple to use.
