<?php
	$db['local'] = array(
		'host'	=> 'localhost',
		'user'	=> 'root',
		'pass' 	=> '',
		'name'	=> 'fork',
		'driver'=> 'mysql',
		'port' 	=> '3306',
	);
	
	$db['live'] = array(
		'host'	=> 'localhost',
		'user'	=> 'root',
		'pass' 	=> '',
		'name'	=> 'main_part_dealer',
		'driver'=> 'mysql',
		'port' 	=> '3306',
	);
	
	$db['faye'] = array(
		'host'	=> 'localhost',
		'user'	=> 'root',
		'pass'	=> '',
		'name'	=> 'faye',
		'driver'=> 'mysql',
		'port'	=> '3306',
	);

	$db['Dpack'] = array(
		'host'	=> '192.168.11.124',
		'user'	=> 'will',
		'pass'	=> 'tralalatrilili',
		'name'	=> 'DpackMainDealerSP',
		'driver'=> 'mssql',
		'port'	=> '',
	);

	$config['database']['default'] = $db['local'];
	$config['database']['Dpack'] = $db['Dpack'];