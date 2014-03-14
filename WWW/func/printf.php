<?php
	$time = time();
	$avail = 0;
	$total = 0;
	echo "<table border='0'><tr>
			<th width=124>Building</th>
			<th width=100>Room</th>
			<th width=100>Comp #</th>
			<th width=100>OS</th>
			<th width=110>Availability</th>
			</tr>";	
	foreach($result as &$row){
      if(class_exists('Memcache'))
      {
          $mc = new Memcache;
          $mc->connect('localhost', 11211);
          $key = 'openlabs_comp_' . strtoupper($row['HOSTNAME']);
          if(!$tstamp = $mc->get($key)){$tstamp = time() - 200;}
          $mc->close();
      }
      else{$tstamp = $row['TIMESTAMP'];}
      if($row == null) break;		
      $total++;
      $diff  = $time - $tstamp;
      $last= floor($diff/60);
      echo "<tr>";
      echo "<td>" . $row['BUILDING'] . "</td>";
      echo "<td>" . $row['ROOM'] . "</td>";
      echo "<td>" . $row['COMPNO'] . "</td>";		
      echo "<td>" . $row['OS'] . "</td>";
      if($diff < 180){echo '<td id="availability" bgcolor=red>In Use</td>';}
      elseif($tstamp == 0){echo '<td id="availability" bgcolor=yellow>Not Set Up</td>';}
      else
      {
          if($row['SERVICE'] > 0){echo '<td id="availability" bgcolor=orange>Not In Service</td>';}
          elseif($row['SERVICE'] == 0){echo '<td id="availability" bgcolor=#30FF30>Available</td>'; $avail++;}
      }		
      echo "</tr>";		
	}
   echo "</table><br><p>$avail / $total Available Computers</p>";
?>