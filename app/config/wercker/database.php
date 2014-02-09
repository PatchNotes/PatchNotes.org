<?php

return array(

	'default' => 'mysql',

	'connections' => array(

		'mysql' => array(
			'driver' => 'mysql',
			'host' => getenv('WERCKER_MYSQL_HOST'),
			'port' => getenv('WERCKER_MYSQL_PORT'),
			'database' => getenv('WERCKER_MYSQL_DATABASE'),
			'username' => getenv('WERCKER_MYSQL_USERNAME'),
			'password' => getenv('WERCKER_MYSQL_PASSWORD'),
			'charset' => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix' => '',
		),

	),

);
