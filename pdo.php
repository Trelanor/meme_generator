<?php

	function connect() {
	
		require 'config.php';
	
		$host       = $config['host'];
		$bdd         = $config['database'];
		$user       = $config['user'];
		$password   = $config['password'];

		try {
	
		  // data source name
		  $dsn     = 'mysql:host='.$host.';dbname='.$bdd.';charset=utf8';
		  $options = [
	
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
	
		  ];
	
		  $pdo = new PDO($dsn, $user, $password, $options);
			
		} catch(PDOException $e) {
	
		  $pdo = null;
	
		}
		
		return $pdo;
	}
	
	$bdd = connect();

?>