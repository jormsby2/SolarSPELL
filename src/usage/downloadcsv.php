<?php
    if (isset($_POST['download'])){
		$connectionstring = 'mysql:host=localhost;dbname=UserData';
		$user = 'root';
		$passwd = 'raspberry';

		try{
			$dbc = new PDO($connectionstring, $user, $passwd);
		}catch(PDOException $e){
			// print error message.
			echo($e->getMessage());
			die();
		}
		$fname = "usagedata-" . date('m-d-Y') . "csv";
		$query = "SELECT * FROM UserLogInfo";
		$statement = $dbc->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		
		$columnNames = array();
		if(!empty($result)){
			$firstRow = $result[0];
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
		foreach($result as $row){
			fputcsv($file, $row);
		}
		fclose($file);
        
        exit();
    }
?>
