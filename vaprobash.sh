curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/bin/composer

cd /vagrant
composer install --prefer-source --no-interaction
npm install