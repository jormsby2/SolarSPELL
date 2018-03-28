<?php
$connectionstring = 'mysql:host=localhost;dbname=UserData';
$user = 'root';
$passwd = 'raspberry';

try{
	$dbh = new PDO($connectionstring, $user, $passwd);
}catch(PDOException $e){
	die();
}
?>