<?php

return array(
	'driver' => 'smtp',
	'host' => 'smtp.gmail.com',
	'port' => 587,
	'from' => array('address' => 'vbolshakov87@gmail.com', 'name' => 'Vladimir'),
	'encryption' => 'tls',
	'username' => 'vbolshakov87',
	'password' => '###',
	'sendmail' => '/usr/sbin/sendmail -bs',
	'pretend' => false,
);