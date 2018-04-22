<?php
	$db = new SQLite3("/var/www/db/UserData.db");

	$db->exec('create table if not exists UserLogInfo (main_category VARCHAR(120), file_name VARCHAR(120), file_path VARCHAR(120), browser VARCHAR(120), device_type VARCHAR(120), os VARCHAR(120))');
	//$db->exec('insert into UserLogInfo (main_category, file_name, file_path, browser, device_type, os) values ("Math", "fractions.pdf", "Math/Fractions", "chrome", "desktop", "Windows")');

	$result = $db->query('select * from UserLogInfo');
	print_r($result->fetchArray());
?>
