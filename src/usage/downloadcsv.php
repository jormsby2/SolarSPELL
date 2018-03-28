<?php
define("DB_PATH", "/var/www/db/UserData.db");

class MyDB extends SQLite3
{
	function __construct() {
		$this->open(DB_PATH);
	}
}

    if (isset($_POST['download'])){
		/*$connectionstring = 'mysql:host=localhost;dbname=UserData';
		$user = 'root';
		$passwd = 'raspberry';

		try{
			$dbc = new PDO($connectionstring, $user, $passwd);
		}catch(PDOException $e){
			// print error message.
			echo($e->getMessage());
			die();
		}*/
		$db = new MyDB();
		$fname = "usagedata-" . date('m-d-Y') . ".csv";
		$query = "SELECT * FROM UserLogInfo";
		//$statement = $dbc->prepare($query);
		$statement = $db->prepare($query);
		//$statement->execute();
		//$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		$result = $statement->execute();
		$columnNames = array();
		$firstRow = [];
		if(!empty($result)){
			//$firstRow = $result[0];
			$firstRow = $result->fetchArray(SQLITE3_ASSOC);
			foreach($firstRow as $colName => $val){
				$columnNames[] = $colName;
			}
		}

        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename="' . $fname . '";');
        header('Pragma: no-cache');
        header('Expires: 0');
        $file = fopen('php://output', 'w');
		fputcsv($file, $columnNames);
		fputcsv($file, $firstRow);
		/*foreach($result as $row){
			fputcsv($file, $row);
		}*/
		while($row = $result->fetchArray(SQLITE3_ASSOC)) {
			fputcsv($file, $row);
		}
		fclose($file);

        exit();
    }
?>
