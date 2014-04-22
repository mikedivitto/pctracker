<?php
$PageTitle="Computer Detail";
function customPageHeader(){?>
<?php }
include_once('header.php');
include_once('../func/sqlconn.php');	
$time = time();
if(strlen($_GET['hname']) == 0 && strlen($_GET['ID']) == 0){
	?>
	<div class="centered-panel">
		<div class="panel panel-default">
			<div class="panel-heading"><center><h1 class="panel-title">Computer Detail</h1></center></div>
			<div class="panel-body">
				<p>Enter Hostname or Select From List Below</p><br>
				<form class="form-inline" action="detail.php" method="get">				
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-4 control-label col-md-4">Hostname</label>
						<div class="col-sm-8 col-md-8">
							<input class="form-control" id="inputEmail3" type="text" name="hname" autofocus>
						</div>
					</div>
					<div class="form-group">
						<div>
							<input class="btn btn-default" type="submit" value="Submit" id="submitbutton">
						</div>
					</div>
				</form>	
				<br><br>
				<?
				$result = mysqli_query($con,"SELECT * FROM " . $DB_COMPUTERS . " ORDER BY `HOSTNAME`");		
				echo "<table border='0'><tr><th width=150>Hostname</th><th width=100>OS</th><th width=100>Building</th><th width=60>Room</th>
					<th width=80>Comp #</th><th width=150>Last Updated*</th><th width=100>Availability</th></tr>";		
				while($row = mysqli_fetch_array($result)){
					if(class_exists('Memcache')){
						$mc = new Memcache;
						$mc->connect('localhost', 11211);
						$key = 'openlabs_comp_' . strtoupper($row['HOSTNAME']);
						if(!$tstamp = $mc->get($key)){$tstamp = time() - 200;}
						$mc->close();
					}
					else{$tstamp = $row['TIMESTAMP'];}
					$tmp=$row['HOSTNAME'];
					$tmpid=$row['ID'];
					$diff  = $time - $tstamp;
					$last= floor($diff/60);
					echo "<tr><td><a href=\"detail.php?hname=$tmp&ID=$tmpid\">" . $row['HOSTNAME'] . "</a></td><td>" . $row['OS'] . "</td>
						<td>" . $row['BUILDING'] . "</td><td>" . $row['ROOM'] . "</td><td>" . $row['COMPNO'] . "</td>";			
					if($tstamp == 0){echo "<td>Not Set Up</td>";}
					else{
						if ($last > 1440){echo "<td>" . floor($last/1440) . " days ago</td>";}
						else {echo "<td>" . $last . " minutes ago</td>";}
					}		
					if($diff < 180){echo '<td id="availability" bgcolor=red>In Use</td>';}
					elseif($tstamp == 0){echo '<td id="availability" bgcolor=yellow>Not Set Up</td>';}
					else
					{
						if($row['SERVICE'] > 0){echo '<td id="availability" bgcolor=orange>Not In Service</td>';}
						elseif($row['SERVICE'] == 0){echo '<td id="availability" bgcolor=#30FF30>Available</td>';}
					}			
					echo "</tr>";
				}	
				echo "</table><br>";
			?>
			</div>	
		</div>
	</div>	
	<?
}
elseif (strlen($_GET['hname']) > 0 && strlen($_GET['ID']) == 0){
	?>
	<div class="centered-panel">
		<div class="panel panel-default">
			<div class="panel-heading"><center><h1 class="panel-title">Computer Detail</h1></center></div>
			<div class="panel-body">
			<?
				echo "<p>Select From List Below</p><br>";
				$result = mysqli_query($con,sprintf("SELECT * FROM " . $DB_COMPUTERS . " WHERE `HOSTNAME`=\"%s\" ORDER BY `HOSTNAME`",mysqli_real_escape_string($con,$_GET['hname'])));		
				echo "<table border='0'><tr><th width=150>Hostname</th><th width=100>OS</th><th width=100>Building</th>
					<th width=60>Room</th><th width=80>Comp #</th><th width=150>Last Updated*</th><th width=100>Availability</th></tr>";		
				while($row = mysqli_fetch_array($result))
				{
					if(class_exists('Memcache')){
						$mc = new Memcache;
						$mc->connect('localhost', 11211);
						$key = 'openlabs_comp_' . strtoupper($row['HOSTNAME']);
						if(!$tstamp = $mc->get($key)){$tstamp = time() - 200;}
						$mc->close();
					}
					else{$tstamp = $row['TIMESTAMP'];}
					$tmp=$row['HOSTNAME'];
					$tmpid=$row['ID'];
					$diff  = $time - $tstamp;
					$last= floor($diff/60);
					echo "<tr><td><a href=\"detail.php?hname=$tmp&ID=$tmpid\">" . $row['HOSTNAME'] . "</a></td><td>" . $row['OS'] . "</td>
						<td>" . $row['BUILDING'] . "</td><td>" . $row['ROOM'] . "</td><td>" . $row['COMPNO'] . "</td>";			
					if($tstamp == 0){echo "<td>Not Set Up</td>";}
					else{
						if ($last > 1440){echo "<td>" . floor($last/1440) . " days ago</td>";}
						else {echo "<td>" . $last . " minutes ago</td>";}
					}		
					if($diff < 180){echo '<td id="availability" bgcolor=red>In Use</td>';}
					elseif($tstamp == 0){echo '<td id="availability" bgcolor=yellow>Not Set Up</td>';}
					else
					{
						if($row['SERVICE'] > 0){echo '<td id="availability" bgcolor=orange>Not In Service</td>';}
						elseif($row['SERVICE'] == 0){echo '<td id="availability" bgcolor=#30FF30>Available</td>';}
					}			
					echo "</tr>";
				}	
				echo "</table><br>";
			?>			
			</div>	
		</div>
	</div>	
	<?	
}	
else
{
	$tmp= $_GET['hname'];		
	$result = mysqli_query($con,sprintf("SELECT * FROM `" . $DB_COMPUTERS . "` WHERE `HOSTNAME`=\"%s\"",mysqli_real_escape_string($con,$tmp)));		
	$row = mysqli_fetch_array($result);	
	if(strlen($_GET['ID']) == 0) {$tmpid = "\"" . $row['ID'] . "\"";}
	else {$tmpid = "\"" . $_GET['ID'] . "\"";}	
	?>
	<div class="centered-panel">
		<div class="panel panel-default">
			<div class="panel-heading"><center><h1 class="panel-title">Detail for Computer: <?echo $row['HOSTNAME'];?></h1></center></div>
			<div class="panel-body">
				<form class="form-horizontal" role="form" action="../func/updateinfo.php" method="post">
					<input type="hidden" name="id" value=<?php echo $tmpid; ?> readonly>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label col-md-3">Hostname</label>
						<div class="col-sm-9 col-md-8 col-lg-6">
							<input class="form-control" id="inputEmail3" type="text" name="os" value="<?php echo $row['HOSTNAME']; ?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label col-md-3">OS</label>
						<div class="col-sm-9 col-md-8 col-lg-6">
							<input class="form-control" id="inputEmail3" type="text" name="os" value="<?php echo $row['OS']; ?>" autofocus>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label col-md-3">Building</label>
						<div class="col-sm-9 col-md-8 col-lg-6">
							<input class="form-control" id="inputEmail3" type="text" name="bldg" value="<?php echo $row['BUILDING']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label col-md-3">Room</label>
						<div class="col-sm-9 col-md-8 col-lg-6">
							<input class="form-control" id="inputEmail3" type="text" name="room" value="<?php echo $row['ROOM']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label col-md-3">Computer Number</label>
						<div class="col-sm-9 col-md-8 col-lg-6">
							<input class="form-control" id="inputEmail3" type="text" name="comp" value="<?php echo $row['COMPNO']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label col-md-3">Service Status</label>
						<div class="col-sm-9 col-md-8 col-lg-6">
							<input class="form-control" id="inputEmail3" type="text" name="srvc" value="<?php echo $row['SERVICE'];?>">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-10">
							<input class="btn btn-default" type="submit" value="Update" id="submitbutton">
						</div>
					</div>
				</form>			
			</div>	
		</div>
	</div>	
	<?	
}
mysqli_close($con);
include_once('footer.php'); 
?>