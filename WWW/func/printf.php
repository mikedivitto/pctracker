<?php
	$time = time();
	$avail = 0;
	$total = 0;
	echo "<table border='0'>
			<tr>";
			//<th width=200>Hostname</th>
			
			echo "<th width=124>Building</th>
			<th width=100>Room</th>
			<th width=100>Comp #</th><th width=100>OS</th>";
			//<th width=175>Last Updated*</th>
			echo "<th width=110>Availability</th>
			</tr>";	
	while($row = mysqli_fetch_array($result))
	{
		$total++;
		$diff  = $time - $row['TIMESTAMP'];
		$last= floor($diff/60);
		echo "<tr>";
		//echo "<td>" . $row['HOSTNAME'] . "</td>";
		
		echo "<td>" . $row['BUILDING'] . "</td>";
		echo "<td>" . $row['ROOM'] . "</td>";
		echo "<td>" . $row['COMPNO'] . "</td>";		
		echo "<td>" . $row['OS'] . "</td>";
		#if($row['TIMESTAMP'] == 0){echo "<td>Not Set Up</td>";}
		#else{echo "<td>" . $last . " minutes ago</td>";}	
		if($diff < 180){echo '<td id="availability" bgcolor=red>Unavailable</td>';}
		elseif($row['TIMESTAMP'] == 0){echo '<td id="availability" bgcolor=yellow>Not Set Up</td>';}
		else
		{
			if($row['SERVICE'] > 0){echo '<td id="availability" bgcolor=orange>Not In Service</td>';}
			elseif($row['SERVICE'] == 0){echo '<td id="availability" bgcolor=#30FF30>Available</td>'; $avail++;}
		}		
		echo "</tr>";
	}	
	echo "</table><br>";
	echo "<p>$avail / $total Available Computers</p>"
?>