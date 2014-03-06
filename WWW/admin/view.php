<?php
$PageTitle="Status";	
function customPageHeader(){?>
<?php }	
include_once('header.php');	
	include_once('../func/sqlconn.php');		
	$result = mysqli_query($con,"SELECT * FROM comptest ORDER BY BUILDING ASC,ROOM ASC,HOSTNAME ASC,COMPNO ASC");
	$time = time();
	echo "<div id=\"status\"><table border='0'>
			<tr>
			<th width=240>Hostname</th>
			<th width=100>OS</th>
			<th width=100>Building</th>
			<th width=60>Room</th>
			<th width=80>Comp #</th>
			<th width=150>Last Updated*</th>";
			/*<th width=125>Last User</th>*/
			echo "<th width=135>Availability</th>
			</tr>";	
	while($row = mysqli_fetch_array($result))
	{
		$diff  = $time - $row['TIMESTAMP'];
		$last= floor($diff/60);
		echo "<tr>";
		echo "<td>" . $row['HOSTNAME'] . "</td>";
		echo "<td>" . $row['OS'] . "</td>";
		echo "<td>" . $row['BUILDING'] . "</td>";
		echo "<td>" . $row['ROOM'] . "</td>";
		echo "<td>" . $row['COMPNO'] . "</td>";		
		if($row['TIMESTAMP'] == 0){echo "<td>Not Set Up</td>";}
		else{
			if ($last > 1440)
				echo "<td>" . floor($last/1440) . " days ago</td>";
			else
				echo "<td>" . $last . " minutes ago</td>";
		}	
		/*echo "<td>" . $row['UNAME'] . "</td>";		*/
		if($diff < 180){echo '<td id="availability" bgcolor=red>In Use</td>';}
		elseif($row['TIMESTAMP'] == 0){echo '<td id="availability" bgcolor=yellow>Not Set Up</td>';}
		else
		{
			if($row['SERVICE'] > 0){echo '<td id="availability" bgcolor=orange>Not In Service</td>';}
			elseif($row['SERVICE'] == 0){echo '<td id="availability" bgcolor=#30FF30>Available</td>';}
		}		
		echo "</tr>";
	}	
	echo "</table><br></div><p>*Availability based on no update for 3 minutes (Subject to change)</p>";	
	mysqli_close($con);	
include_once('footer.php');
?>
