curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/bin/composer

cd /vagrant
composer install --prefer-source --no-interaction

# Due to an issue in vaprobash
mkdir /home/vagrant/npm
npm install

npm install -g gulp
npm install -g bower