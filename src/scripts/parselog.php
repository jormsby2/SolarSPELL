<?php
define("LOG_PATH", "/var/log/apache2/access1.log");

function process_line($line) {
	$tokens = explode(" ", $line, 3);

	//only handle "GET" requests (content accessed)
	if ($tokens[1] == "GET") {
		$tokens = explode('"', $tokens[2]);
		$content_path = $tokens[0];
		$user_agent = $tokens[1];

		//process content (category and filename)
		$tokens = explode("/", $content_path);
		$main_category = $tokens[3];
		$file_name = $tokens[count($tokens)-1];

		//process user agent (os and browser)
		$ua_arr = get_browser($user_agent, true);
		$browser = $ua_arr['parent'];
		$device_type = $ua_arr['device_type'];
		$os = $ua_arr['platform'];
		//$is_mobile_device = $ua_arr['ismobiledevice'];
		//$is_tablet = $ua_arr['istablet'];

		// Upload Data
		$servername = "localhost";
		$username = "root";
		$password = "raspberry";
		$dbname = "UserData";

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		
		// Check connection
		if ($conn->connect_error) {
		    die("Connection failed: " . $conn->connect_error);
		} 

		$sql = "INSERT INTO UserData.UserDataInfo (content_path, user_agent, main_category, file_name)
		VALUES (" . $content_path . ", " . $user_agent . "," . $main_category . "," . $file_name . ")";

		if ($conn->query($sql) === TRUE) {
		    echo "New record created successfully";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}

		$conn->close();

		// End Upload

		//String keys
		return ["category"=>$main_category,
			"file"=>$file_name,
			"browser"=>$browser,
			"device"=>$device_type,
			"os"=>$os];

		//No string keys
		/*
		return [$main_category,
			$file_name,
			$browser,
			$device_type,
			$os];
		*/
	}
}

function get_data() {
	$handle = fopen(LOG_PATH, "r");

	if ($handle) {
		$data = [];
		while(($line = fgets($handle)) !== false) {
			array_push($data, process_line($line));
		}

		fclose($handle);
    
		return $data;
	}
}

$data = get_data();

if ($data) {
	print_r($data);
}
?>
