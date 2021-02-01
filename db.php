<?php

define('DBNAME', 'test');
define('DBUSER', 'root');
define('DBPASS', '');

$dsn = "mysql:host=localhost;dbname=" . DBNAME;

try{
	$pdo = new PDO($dsn, DBUSER, DBPASS);
}catch(PDOException $e){
	echo $e->getMessage();
}