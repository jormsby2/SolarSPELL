/*
 * This page formats the log data into a pi chart to show user access by category. I am currently using dummy data
 * until we figure out the database and logging.
*/
<?php
/*
 * Below is an example of what getting the data will look like once we have the database and logging figured out
$conn = mysqli_connect(connection to my sql db);
$query = "SELECT category, count(*) as number FROM tbl_logs GROUP BY category";
$result = mysqli_query($conn, $query);
*/
// dummy data to work on this task while we figure out our logging issues
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pi Chart of User Access</title>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart()
        {
            // below is commented out until we have a proper result from the mysql database
            //var data = google.visualization.arrayToDataTable([
           // ['Category', 'Number'],
            <?php
            /*
            while($row = mysqli_fetch_array($result))
            {
                echo "['".$row["category"]."', ".$row["number"]."],";
            }
            */
            ?>
            //]);
            var data = google.visualization.arrayToDataTable([
                ['Category', 'Times Accessed'],
                ['Environment', 110],
                ['Health and Safety', 12],
                ['Language Arts', 17],
                ['Local Topics', 24],
                ['Math', 35],
                ['Science', 24]
            ]);

        var options = {
            title: 'Percentage of Access to Each Category',
            pieHole: 0.1
        };
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
        }
    </script>
</head>
<body>
<br /><br />
<div style="width:900px;">
    <h3 align="center">Pi Chart of User Access</h3>
    <br />
    <div id="piechart" style="width: 900px; height: 500px;"></div>
</div>
</body>
</html>