# Schiphol
Script to determine which of the 6 runways on Schiphol Airport are used
for starting or landing and notify using prowl if a change is detected

## Installation
```php
Install composer. Follow instructions on: https://getcomposer.org/download/
clone the project: git clone https://github.com/Rubyan/Schiphol.git
install the composer dependencies: cd <project dir>; php composer.phar install
```

## Cron configuration on raspberry pi
Use cron to schedule the program to run every 5 minutes:
```bash
# m h  dom mon dow   command
*/5 * * * * cd /var/www/html/schiphol && /usr/bin/php /var/www/html/schiphol/index.php
```

## Prowl
Prowl https://www.prowlapp.com/ is a paid service to deliver push notifications to your iPhone.
The api is extremely simple to use. Configure your api key in index.php and you're good to go.
