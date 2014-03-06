<?php
$PageTitle="Remove Computer";
function customPageHeader(){?>
<?php }
include_once('header.php');
include_once('../func/sqlconn.php');
	$time = time();
if(strlen($_GET['hname']) == 0 && strlen($_GET['id']) == 0)
{
	echo "<h1>Remove Computer</h1><p>Enter Hostname or Select From List Below</p><br>
	<form action=\"remove.php\" method=\"get\">Hostname: <input type=\"text\" name=\"hname\" autofocus><br>
	<input type=\"submit\" value=\"Submit\" id=\"submitbutton\">
	</form><br><br>";
	$result = mysqli_query($con,"SELECT * FROM comptest ORDER BY `HOSTNAME`");
	echo "<table border='0'>
	<tr>
	<th width=150>Hostname</th>
	<th width=100>OS</th>
	<th width=100>Building</th>
	<th width=60>Room</th>
	<th width=80>Comp #</th>
	<th width=150>Last Updated*</th>
	<th width=100>Availability</th>
	</tr>";	
	while($row = mysqli_fetch_array($result))
	{
		$tmp=$row['HOSTNAME'];
		$tmpid=$row['ID'];
		$diff  = $time - $row['TIMESTAMP'];
		$last= floor($diff/60);
		echo "<tr>";
		echo "<td><a href=\"confirm.php?hname=$tmp&id=$tmpid\">" . $row['HOSTNAME'] . "</a></td>";
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
		if($diff < 180){echo '<td id="availability" bgcolor=red>Unavailable</td>';}
		elseif($row['TIMESTAMP'] == 0){echo '<td id="availability" bgcolor=yellow>Not Set Up</td>';}
		else
		{
			if($row['SERVICE'] > 0){echo '<td id="availability" bgcolor=orange>Not In Service</td>';}
			elseif($row['SERVICE'] == 0){echo '<td id="availability" bgcolor=green>Available</td>';}
		}	
		echo "</tr>";
	}	
	echo "</table><br>";	
}
else
{
	echo "<h1>Remove Computer</h1><p>Select From List Below</p><br>";
$tmp = "\"" . $_GET['hname'] . "\"";
$result = mysqli_query($con,"SELECT * FROM comptest WHERE `HOSTNAME`=" . $tmp . " ORDER BY `HOSTNAME`");
	echo "<table border='0'>
	<tr>
	<th width=150>Hostname</th>
	<th width=100>OS</th>
	<th width=100>Building</th>
	<th width=60>Room</th>
	<th width=80>Comp #</th>
	<th width=150>Last Updated*</th>
	<th width=100>Availability</th>
	</tr>";	
	while($row = mysqli_fetch_array($result))
	{
		$tmp=$row['HOSTNAME'];
		$tmpid=$row['ID'];
		$diff  = $time - $row['TIMESTAMP'];
		$last= floor($diff/60);
		echo "<tr>";
		echo "<td><a href=\"confirm.php?hname=$tmp&id=$tmpid\">" . $row['HOSTNAME'] . "</a></td>";
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
		if($diff < 180){echo '<td id="availability" bgcolor=red>Unavailable</td>';}
		elseif($row['TIMESTAMP'] == 0){echo '<td id="availability" bgcolor=yellow>Not Set Up</td>';}
		else
		{
			if($row['SERVICE'] > 0){echo '<td id="availability" bgcolor=orange>Not In Service</td>';}
			elseif($row['SERVICE'] == 0){echo '<td id="availability" bgcolor=green>Available</td>';}
		}	
		echo "</tr>";
	}	
}
	include_once('footer.php');
	mysqli_close($con);
include_once('footer.php'); 
?>