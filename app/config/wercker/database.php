<?php

return array(

	'default' => 'mysql',

	'connections' => array(

		'mysql' => array(
			'driver' => 'mysql',
			'host' => $_ENV['WERCKER_MYSQL_HOST'],
			'port' => $_ENV['WERCKER_MYSQL_PORT'],
			'database' => $_ENV['WERCKER_MYSQL_DATABASE'],
			'username' => $_ENV['WERCKER_MYSQL_USERNAME'],
			'password' => $_ENV['WERCKER_MYSQL_PASSWORD'],
			'charset' => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix' => '',
		),

	),

);
