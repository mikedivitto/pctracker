<?php
$PageTitle="Status";	
function customPageHeader(){?>
<?php }	
include_once('header.php');	
	include_once('../func/sqlconn.php');		
	
	if(class_exists('Memcache'))
	{
		$mc = new Memcache;
		$mc->connect('localhost', 11211);
		if(!$result = $mc->get('openlabs_admin_all')){
			$tmp = mysqli_query($con,"SELECT * FROM comptest ORDER BY BUILDING ASC,ROOM ASC,HOSTNAME ASC,COMPNO ASC");
			$result = array();
			while ($row = mysqli_fetch_assoc($tmp)) {
				array_push($result, $row);	
			}
			$mc->set('openlabs_admin_all', $result, 0, 30);
		}
		$mc->close();
	}
	else{
		$tmp = mysqli_query($con,"SELECT * FROM comptest ORDER BY BUILDING ASC,ROOM ASC,HOSTNAME ASC,COMPNO ASC");
		$result = array();
		while ($row = mysqli_fetch_assoc($tmp)) {
			array_push($result, $row);	
		}
	}	
	
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
			
			
	foreach($result as &$row)
	{
        if(class_exists('Memcache'))
        {
            $mc = new Memcache;
            $mc->connect('localhost', 11211);
            $key = 'openlabs_comp_' . strtoupper($row['HOSTNAME']);
            if(!$tstamp = $mc->get($key)){
                $tstamp = time() - 200;
            }
            $mc->close();
        }
        else{
            $tstamp = $row['TIMESTAMP'];
        }
		$diff  = $time - $tstamp;
		$last= floor($diff/60);
		echo "<tr>";
		echo "<td>" . $row['HOSTNAME'] . "</td>";
		echo "<td>" . $row['OS'] . "</td>";
		echo "<td>" . $row['BUILDING'] . "</td>";
		echo "<td>" . $row['ROOM'] . "</td>";
		echo "<td>" . $row['COMPNO'] . "</td>";		
		if($tstamp == 0){echo "<td>Not Set Up</td>";}
		else{
			if ($last > 1440)
				echo "<td>" . floor($last/1440) . " days ago</td>";
			else
				echo "<td>" . $last . " minutes ago</td>";
		}	
		/*echo "<td>" . $row['UNAME'] . "</td>";		*/
		if($diff < 180){echo '<td id="availability" bgcolor=red>In Use</td>';}
		elseif($tstamp == 0){echo '<td id="availability" bgcolor=yellow>Not Set Up</td>';}
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
