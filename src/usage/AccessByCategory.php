<?php
/*
 * This page formats the log data into a pi chart to show user access by category.
*/

define("DB_PATH", "/var/www/db/UserData.db");
$query = "SELECT main_category, count(*) as number FROM UserLogInfo GROUP BY main_category";

class MyDB extends SQLite3
{
	function __construct() {
		$this->open(DB_PATH);
	}
}

$db = new MyDB();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pi Chart of User Access</title>
</head>
<body>
<br /><br />
<div>
    <h3 align="center">Pi Chart of User Access</h3>
    <br />
    <div id="piechart-container" style="margin: auto; width: 400px; height: 400px">
        <canvas id="piechart" style="width: 100%; height: 100%;"></canvas>
    </div>
</div>
<script type="text/javascript" src="Chart.min.js"></script>
<script type="text/javascript">
	function getData() {
		return([
			<?php
			$result = $db->query($query);

			while($row = $result->fetchArray(SQLITE3_ASSOC)) {
				echo "['" . $row["main_category"] . "', " . $row["number"] . "],";
			}
			?>
		]);
	}

	function getRand(min, max) {
		min = Math.ceil(min);
		max = Math.floor(max);
		return Math.floor(Math.random() * (max - min + 1)) + min;
	}

	function drawChart(elem_id, data) {
		var bgcs = [];
		var length = data.length;
		var categories = data.map(function(x) { return x[0] });
		var counts = data.map(function(x) { return x[1] });

		for (var i = 0; i < length; i++) {
			bgcs.push('rgb(' + getRand(0,255) + ',' + getRand(0, 255) + ',' + getRand(0,255) +  ')');
		}

		var data = {
			datasets: [{
				backgroundColor: bgcs,
				data: counts
			}],

			labels: categories
		};

		var options = {};
		var ctx = document.getElementById(elem_id).getContext('2d');
		var chart = new Chart(ctx, {
			type: 'pie',
			data: data,
			options: options
		});
	}

  var chartData = getData();

  if (chartData.length === 0) {
    var pieChartContainer = document.getElementById('piechart-container');

    pieChartContainer.style.display = 'flex';
    pieChartContainer.style.justifyContent = 'center';
    pieChartContainer.innerHTML = '<div style="font-size: 20px;">No Data</div>';
  } else {
    drawChart('piechart', chartData);
  }
</script>
</body>
</html>
