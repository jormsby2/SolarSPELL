<?php
/*
* This page formats the log data into a formatted table to show most accessed files. I am currently using dummy data
* until we figure out the database and logging.

Below is an example of what getting the data will look like once we have the database and logging figured out
$conn = mysqli_connect(connection to my sql db);
$query = "SELECT fileName, Category, count(*) as Number
    FROM tableName
    GROUP BY fileName
    ORDER BY count(*) DESC";
$result = mysqli_query($conn, $query);
*/

function build_table($tableArray){
    // start table, use bootstrap table css and include grid lines
    $html = '<table class="table" border="1">';
    // header row
    $html .= '<tr>';
    foreach($tableArray[0] as $key=>$value){
        $html .= '<th>' . htmlspecialchars($key) . '</th>';
    }
    $html .= '</tr>';

    // data rows
    foreach( $tableArray as $key=>$value){
        $html .= '<tr>';
        foreach($value as $key2=>$value2){
            $html .= '<td>' . htmlspecialchars($value2) . '</td>';
        }
        $html .= '</tr>';
    }

    // finish table and return it

    $html .= '</table>';
    return $html;
}

// below is dummy data that SHOULD be coming from $result instead. Once we have the database connection string worked out
// we can create the array from the database result
$tableArray = array(
    array('File'=>'Maya.svg', 'Category'=>'Math', 'Times Accessed'=>'5'),
    array('File'=>'Fishing_down_the_food_web.png', 'Category'=>'Science', 'Times Accessed'=>'2'),
    array('File'=>'Inscription_displaying_apices_(from_the_shrine_of_the_Augustales_at_Herculaneum).jpg', 'Category'=>'Language Arts', 'Times Accessed'=>'1')
);
?>

    <script src="../js/bootstrap.js"></script>

<?php
echo build_table($tableArray);
?>