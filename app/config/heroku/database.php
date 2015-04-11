<?php
$url = parse_url(getenv("HEROKU_POSTGRESQL_MAUVE_URL"));

$host = $url["host"];
$username = $url["user"];
$password = $url["pass"];
$database = substr($url["path"], 1);

return array(
	'connections' => array(
		'pgsql' => array(
			'driver'	=> 'pgsql',
			'host'		=> $host,
			'database'	=> $database,
			'username'	=> $username,
			'password'	=> $password,
			'charset' 	=> 'utf8',
			'prefix'	=> '',
			'schema'	=> 'public',
		),
	),
);
