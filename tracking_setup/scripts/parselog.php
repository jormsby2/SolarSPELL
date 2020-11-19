<?php
define("PARSE_MIN_SIZE", 1000000); //bytes
define("ENFORCE_MIN_SIZE", FALSE);

define("LOG_PATH", "/var/log/apache2/access1.log");
define("TMP_LOG_DIR_PATH", "/var/log/apache2/");
define("DATA_PATH", "/var/log/apache2/access2.log");

define("DB_PATH", "/var/www/db/UserData.db");

class MyDB extends SQLite3
{
	function __construct() {
		$this->open(DB_PATH);
	}
}

function clear_log($source_path, $dest_dir_path = NULL) {
	if (isset($dest_dir_path)) {
		$dest_path = $dest_dir_path . basename($source_path) . ".bak";
	} else {
		$dest_path = $source_path . ".bak";
	}

	copy($source_path, $dest_path);

	//cannot remove file or apache logger will lose pointer to it
	file_put_contents($source_path, "");

	return $dest_path;
}

function remove_duplicates($source_path, $dest_path) {

	$lines = [];
	exec("sort -u " . $source_path, $lines);
	$file = fopen($dest_path, "w");

	foreach ($lines as $line) {
		fwrite($file, $line . "\n");
	}

	fclose($file);

	return $dest_path;
}

function process_line($line) {
	$tokens = explode(" ", $line, 3);

	//only handle "GET" requests (content accessed)
	if ($tokens[1] == "GET") {
		$tokens = explode('"', $tokens[2]);
		$content_path = $tokens[0];
		$user_agent = $tokens[1];

		//process content (category and filename)
		$tokens = explode("/", $content_path);
		$tokens = array_slice($tokens, 3);
		$main_category = $tokens[0];
		$file_name = trim($tokens[count($tokens)-1]);
		array_pop($tokens);
		$file_path = implode("/", $tokens);

		//process user agent (os and browser)
		$ua_arr = get_browser($user_agent, true);
		$browser = $ua_arr['parent'];
		$device_type = $ua_arr['device_type'];
		$os = $ua_arr['platform'];

		//String keys
		return ["category"=>$main_category,
			"file"=>$file_name,
			"path"=>$file_path,
			"browser"=>$browser,
			"device"=>$device_type,
			"os"=>$os];

	}
}

function get_data($source_path) {
	$handle = fopen($source_path, "r");

	if ($handle) {
		$data = [];

		while(($line = fgets($handle)) !== false) {
			if (trim($line) !== "") {
				$line = preg_replace("/(\\\\)([a-z,0-9])([a-z,0-9])/i","",$line);
				echo $line;
				array_push($data, process_line($line));
			}
		}

		fclose($handle);

		return $data;
	}
}

if (!ENFORCE_MIN_SIZE || (filesize(LOG_PATH) > PARSE_MIN_SIZE)) {
	$temp_log_path = clear_log(LOG_PATH);
	$data_path = remove_duplicates($temp_log_path, DATA_PATH);
	$data = get_data($data_path);

	if (!empty($data)) {
		$db = new MyDB();

		$db->exec("BEGIN;");

		foreach($data as $entry) {
			$statement = $db->prepare("INSERT INTO UserLogInfo (main_category, file_name, file_path, browser, device_type, os) VALUES (:category, :file, :path, :browser, :device, :os)");
			$statement->bindValue(":category", $entry["category"]);
			$statement->bindValue(":file", $entry["file"]);
			$statement->bindValue(":path", $entry["path"]);
			$statement->bindValue(":browser", $entry["browser"]);
			$statement->bindValue(":device", $entry["device"]);
			$statement->bindValue(":os", $entry["os"]);
			$result = $statement->execute()->finalize();
		}

		$db->exec("COMMIT;");
	}
}
?>
