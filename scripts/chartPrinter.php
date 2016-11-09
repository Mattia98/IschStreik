<?php
	function createChart($name, $idName, $stats) {
		?>
		<script type="text/javascript">
		(() => {
			
     		google.charts.setOnLoadCallback(drawChart);
     		function drawChart() {
       		var data = google.visualization.arrayToDataTable([
         	['Key', 'Value']
         	<?php
         		echo getChartData($stats);
				?>
       		]);
        		var options = {
         		title: "<?php echo $name; ?>",
         		pieHole: 0.4,
         		backgroundColor: "transparent",
         		legend: {position: 'bottom', textStyle: {color: 'blue', fontSize: 16}, maxElement: 1},
         		chartArea: {left:10,top:0,right:10,width:'100%',height:'90%'}
       		};
       
       	var chart = new google.visualization.PieChart(document.getElementById("<?php echo $idName; ?>"));
       	chart.draw(data, options);
      }
      })();
   	</script><?php
	}
	
	function getChartData($stats) {
		$return="";
		//var_dump($stats);
      foreach($stats as $stat) {
	   	$return .= ",\n";
	      $return .= "  ['".$stat['value']."', ".$stat['amount']."]";
		}
		return $return;
	}
?>