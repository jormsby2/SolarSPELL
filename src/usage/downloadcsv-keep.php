<?php
define("DB_PATH", "/var/www/db/UserData.db");

class MyDB extends SQLite3
{
	function __construct() {
		$this->open(DB_PATH);
	}
}

    if (isset($_POST['keep'])){
      $db = new MyDB();

      if (isset($_POST['userdate']) && $_POST['userdate'] != "") {
        $currdate = $_POST['userdate'];
      } else {
        $currdate = date('m-d-Y');
      }

      $fname = "usagedata-" . $currdate . ".csv";
      $query = "SELECT * FROM UserLogInfo";

      $statement = $db->prepare($query);

      $result = $statement->execute();
      $columnNames = array();
      $firstRow = [];
      if(!empty($result)){
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

      while($row = $result->fetchArray(SQLITE3_ASSOC)) {
        fputcsv($file, $row);
      }
      fclose($file);

      exit();
    }
?>
