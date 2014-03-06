<?php
$PageTitle="Computer Detail";
function customPageHeader(){?>
<?php }
include_once('header.php');
	include_once('../func/sqlconn.php');	
	$time = time();
	if(strlen($_GET['hname']) == 0 && strlen($_GET['ID']) == 0)
	{
		echo "<h1>Computer Detail</h1><p>Enter Hostname or Select From List Below</p><br><form action=\"detail.php\" method=\"get\">";
		echo "Hostname:        <input type=\"text\" name=\"hname\" autofocus><br><input type=\"submit\" value=\"Submit\" id=\"submitbutton\"></form><br><br>";					
		$result = mysqli_query($con,"SELECT * FROM comptest ORDER BY `HOSTNAME`");		
		echo "<table border='0'><tr><th width=150>Hostname</th><th width=100>OS</th><th width=100>Building</th><th width=60>Room</th>
			   <th width=80>Comp #</th><th width=150>Last Updated*</th><th width=100>Availability</th></tr>";		
		while($row = mysqli_fetch_array($result))
		{
			$tmp=$row['HOSTNAME'];
			$tmpid=$row['ID'];
			$diff  = $time - $row['TIMESTAMP'];
			$last= floor($diff/60);
			echo "<tr><td><a href=\"detail.php?hname=$tmp&ID=$tmpid\">" . $row['HOSTNAME'] . "</a></td><td>" . $row['OS'] . "</td>
			      <td>" . $row['BUILDING'] . "</td><td>" . $row['ROOM'] . "</td><td>" . $row['COMPNO'] . "</td>";			
			if($row['TIMESTAMP'] == 0){echo "<td>Not Set Up</td>";}
			else{
				if ($last > 1440){echo "<td>" . floor($last/1440) . " days ago</td>";}
				else {echo "<td>" . $last . " minutes ago</td>";}
			}		
			if($diff < 180){echo '<td id="availability" bgcolor=red>In Use</td>';}
			elseif($row['TIMESTAMP'] == 0){echo '<td id="availability" bgcolor=yellow>Not Set Up</td>';}
			else
			{
				if($row['SERVICE'] > 0){echo '<td id="availability" bgcolor=orange>Not In Service</td>';}
				elseif($row['SERVICE'] == 0){echo '<td id="availability" bgcolor=#30FF30>Available</td>';}
			}			
			echo "</tr>";
		}	
		echo "</table><br>";
	}
	elseif (strlen($_GET['hname']) > 0 && strlen($_GET['ID']) == 0)
	{
		echo "<h1>Computer Detail</h1><p>Select From List Below</p><br>";
		$result = mysqli_query($con,"SELECT * FROM comptest WHERE `HOSTNAME`=\"" . $_GET['hname'] . "\" ORDER BY `HOSTNAME`");		
		echo "<table border='0'><tr><th width=150>Hostname</th><th width=100>OS</th><th width=100>Building</th>
			<th width=60>Room</th><th width=80>Comp #</th><th width=150>Last Updated*</th><th width=100>Availability</th></tr>";		
		while($row = mysqli_fetch_array($result))
		{
			$tmp=$row['HOSTNAME'];
			$tmpid=$row['ID'];
			$diff  = $time - $row['TIMESTAMP'];
			$last= floor($diff/60);
			echo "<tr><td><a href=\"detail.php?hname=$tmp&ID=$tmpid\">" . $row['HOSTNAME'] . "</a></td><td>" . $row['OS'] . "</td>
			      <td>" . $row['BUILDING'] . "</td><td>" . $row['ROOM'] . "</td><td>" . $row['COMPNO'] . "</td>";			
			if($row['TIMESTAMP'] == 0){echo "<td>Not Set Up</td>";}
			else{
				if ($last > 1440){echo "<td>" . floor($last/1440) . " days ago</td>";}
				else {echo "<td>" . $last . " minutes ago</td>";}
		   }		
			if($diff < 180){echo '<td id="availability" bgcolor=red>In Use</td>';}
			elseif($row['TIMESTAMP'] == 0){echo '<td id="availability" bgcolor=yellow>Not Set Up</td>';}
			else
			{
				if($row['SERVICE'] > 0){echo '<td id="availability" bgcolor=orange>Not In Service</td>';}
				elseif($row['SERVICE'] == 0){echo '<td id="availability" bgcolor=#30FF30>Available</td>';}
			}			
			echo "</tr>";
		}	
		echo "</table><br>";
	}	
	else
	{	
		$tmp= "\"" . $_GET['hname'] . "\"";		
		$result = mysqli_query($con,"SELECT * FROM `comptest` WHERE `HOSTNAME`=$tmp");		
		$row = mysqli_fetch_array($result);	
		if(strlen($_GET['ID']) == 0) {$tmpid = "\"" . $row['ID'] . "\"";}
		else {$tmpid = "\"" . $_GET['ID'] . "\"";}	
		echo '<form action="../func/updateinfo.php" method="post">';
		echo "<h1>Detail for Computer: " . $row['HOSTNAME'] . "</h1><br>";	
		echo "DB ID: <input type=\"text\" name=\"id\" value=" . $tmpid . " readonly><br>";
		echo "Hostname:  (Cannot Change)      <input type=\"text\" name=\"hname\" value=" . $row['HOSTNAME'] . " readonly><br>";
		echo "OS:		 <input type=\"text\" name=\"os\" value=" . $row['OS'] . "><br>";
		echo "Building:        <input type=\"text\" name=\"bldg\" value=" . $row['BUILDING'] . "><br>";
		echo "Room:            <input type=\"text\" name=\"room\" value=" . $row['ROOM'] . "><br>";
		echo "Computer Number: <input type=\"text\" name=\"comp\" value=" . $row['COMPNO'] . "><br>";
		echo "Service Status: (Enter 0 By Default)<input type=\"text\" name=\"srvc\" value=" . $row['SERVICE'] . "> <br><br>";
		echo '<input type="submit" value="Update" id="submitbutton">';
		echo '</form>';	
	}
	mysqli_close($con);
include_once('footer.php'); 
?>