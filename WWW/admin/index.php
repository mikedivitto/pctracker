<?php
$PageTitle="Admin Console";	
function customPageHeader(){?>
<?php }	
include_once('header.php');	
include_once('../func/sqlconn.php');		
if(class_exists('Memcache')){
	$mc = new Memcache;
	$mc->connect('localhost', 11211);
	if(!$result = $mc->get('openlabs_admin_all')){
		$tmp = mysqli_query($con,"SELECT * FROM " . $DB_COMPUTERS . " ORDER BY BUILDING ASC,ROOM ASC,HOSTNAME ASC,COMPNO ASC");
		$result = array();
		while ($row = mysqli_fetch_assoc($tmp)) {array_push($result, $row);}
		$mc->set('openlabs_admin_all', $result, 0, 30);
	}
	$mc->close();
}
else{
	$tmp = mysqli_query($con,"SELECT * FROM " . $DB_COMPUTERS . " ORDER BY BUILDING ASC,ROOM ASC,HOSTNAME ASC,COMPNO ASC");
	$result = array();
	while ($row = mysqli_fetch_assoc($tmp)) {array_push($result, $row);}
}	

$time = time();
$avail = 0;
$total = 0;

$tablestring;
foreach($result as &$row){
	if($row == null) break;	
	if(class_exists('Memcache'))
	{
	  $mc = new Memcache;
	  $mc->connect('localhost', 11211);
	  $key = 'openlabs_comp_' . strtoupper($row['HOSTNAME']);
	  if(!$tstamp = $mc->get($key)){$tstamp = time() - 200;}
	  $mc->close();
	}
	else{$tstamp = $row['TIMESTAMP'];}
	$diff  = $time - $tstamp;
	$last= floor($diff/60);
	if($diff < 180){$stat="danger";}
	elseif($tstamp == 0){$stat="warning";}
	else
	{
		if($row['SERVICE'] > 0){$stat="warning";}
		elseif($row['SERVICE'] == 0){$stat="success"; $avail++;}
	}			
	$total++;
	$tablestring = $tablestring . "<tr class=" . $stat . "><td>" . $row['HOSTNAME'] . "</td><td>" . $row['OS'] . "</td><td>" . $row['BUILDING'] . "</td><td>" . $row['ROOM'] . "</td><td>" . $row['COMPNO'] . "</td><td>" . $last . " Minutes Ago</td></tr>";		
}	
?>
<div class="">
	<div class="panel panel-default centered-panel">
		<div class="panel-heading"><center><h1 class="panel-title">ALL COMPUTERS</h1></center></div>
		<div class="panel-body">
			<table class="table table-responsive">
				<thead>
					<tr>
						<th>Hostname</th>
						<th>OS</th>
						<th>Building</th>
						<th>Room</th>
						<th>Num.</th>
						<th>Last Updated*</th>
					</tr>
				</thead>
				<tbody>
				<?php echo $tablestring; ?>		
				</tbody>
			</table>
		</div>	
		<div class="panel-footer">*Availability based on no update for 3 minutes (Subject to change)</div>
	</div>
</div>
	<?
mysqli_close($con);	
include_once('footer.php');
?>
