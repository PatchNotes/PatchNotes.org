## PatchNotes [![Stories in Ready](https://badge.waffle.io/PatchNotes/PatchNotes.org.png?label=ready)](http://waffle.io/PatchNotes/PatchNotes.org) [![wercker status](https://app.wercker.com/status/0d6d75950a89752cd448d2e85acced1a "wercker status")](https://app.wercker.com/project/bykey/0d6d75950a89752cd448d2e85acced1a)
Follow up on your favorite projects & services

### Using Vagrant
 - `git clone https://github.com/PatchNotes/PatchNotes.org.git`
 - `vagrant up`

### Install Guide
To run PatchNotes, you'll need a PHP 5.5 setup and the gulp and bower npm modules installed.

 - `git clone https://github.com/PatchNotes/PatchNotes.org.git`
 - `curl -sS https://getcomposer.org/installer | php`
 - `php composer.phar install`
 - `npm install`
 - Setup your database and add your configuration details to app/config/database.php
 - `php artisan migrate`
 - `php artisan serve`

