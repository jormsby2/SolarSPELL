<?php
$host = 'localhost';
$user = 'root';
$passwd = 'raspberry';
$dbname = 'UserData';
$db = new mysqli($host, $user, $passwd, $dbname);
if($db->connect_error){
	die("Can't connect to UserData:" . $db->connect_error);
}
?>