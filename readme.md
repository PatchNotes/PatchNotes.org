## PatchNotes [![Stories in Ready](https://badge.waffle.io/PatchNotes/PatchNotes.org.png?label=ready)](http://waffle.io/PatchNotes/PatchNotes.org) [![Build Status](https://travis-ci.org/PatchNotes/PatchNotes.org.png?branch=master)](https://travis-ci.org/PatchNotes/PatchNotes.org)
Follow up on your favorite projects & services



### Install Guide
To run PatchNotes, you'll need a PHP 5.5 setup.

 - `git clone https://github.com/PatchNotes/PatchNotes.org.git`
 - `curl -sS https://getcomposer.org/installer | php`
 - `php composer.phar install`
 - Setup your database and add your configuration details to app/config/database.php
 - `php artisan migrate`
 - `php artisan serve`


### Technical Documentation
<pre>
There are 3 task runners
pn_immediate is a daemon, pn_daily and pn_weekly are cron jobs
- pn_immediate - These get handled constantly by the server, not in batches.
  Message Retention Period: 1 day
- pn_daily - The runner takes everything in this queue and batches it together per project
  Message Retention Period: 7 days
- pn_weekly - The runner takes everything in this queue and batches it together per project
  Message Retention Period: 14 days
</pre>

### Vocabulary

