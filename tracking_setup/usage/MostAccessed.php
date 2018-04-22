<?php
/*
* This page formats the log data into a formatted table to show most accessed files.
*/

define("DB_PATH", "/var/www/db/UserData.db");
$query = "SELECT file_name, main_category, count(*) as Number
    FROM UserLogInfo
    GROUP BY file_name
    ORDER BY count(*) DESC";

class MyDB extends SQLite3
{
	function __construct() {
		$this->open(DB_PATH);
	}
}

function build_table($tableArray){
    // start table, use bootstrap table css and include grid lines
    $html = '<table id="main-table" class="stripe hover row-border" spacing="0" width="100%">';
    // header row
    $html .= '<thead>';
    $html .= '<tr>';
    foreach($tableArray[0] as $key=>$value){
        $html .= '<th>' . htmlspecialchars($key) . '</th>';
    }
    $html .= '</tr>';
    $html .= '</thead>';

    // data rows
    $html .= '<tbody>';
    foreach( $tableArray as $key=>$value){
        $html .= '<tr>';
        foreach($value as $key2=>$value2){
            $html .= '<td>' . htmlspecialchars($value2) . '</td>';
        }
        $html .= '</tr>';
    }

    $html .= '</tbody>';

    // finish table and return it

    $html .= '</table>';
    return $html;
}

//$tableArray = [];

//while($row = $result->fetchArray(SQLITE3_ASSOC)) {
//	array_push($tableArray, ['File'=>$row["file_name"], 'Category'=>$row["main_category"], 'Times Accessed'=>$row["Number"]]);
//}

function get_table_data() {
	$query = "SELECT file_name, main_category, count(*) as Number
	FROM UserLogInfo
	GROUP BY file_name
	ORDER BY count(*) DESC";

	$db = new MyDB();
	$result = $db->query($query);
	$jsondata = '{"data": [';

	while($row = $result->fetchArray(SQLITE3_ASSOC)) {
		$jsondata .= '{"File": "' . $row["file_name"] . '",' . '"Category": "' . $row["main_category"] . '",' . '"Times Accessed": "' . $row["Number"] . '"},';
	}

	$jsondata = rtrim($jsondata, ",");
	$jsondata .=  ']}';

	return $jsondata;
}
?>

<?php
echo (get_table_data());
?>
