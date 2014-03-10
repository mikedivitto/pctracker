<?php
$PageTitle="Record Added";
function customPageHeader(){?>
	<script type="text/JavaScript">
	<!--
	setTimeout("location.href = '../admin/index.php';",1500);
	-->
	</script>
<?php }
include_once('../admin/headernl.php');
if(strlen($_POST[hname]) == 0){echo "ERROR: NO HOSTNAME SPECIFIED.";}
else
{
	include_once('sqlconn.php');
	$result = mysqli_query($con,"SELECT * FROM `rooms`");	
	$buildings = array();
	$rooms = array();
	while($row = mysqli_fetch_array($result)) 
	{
		if(!in_array($row['BUILDING'],$buildings)){array_push($buildings,$row['BUILDING']);}
		if(!in_array($row['ROOM'],$rooms)){array_push($rooms,$row['ROOM']);	}
	}
	if(!in_array($_POST['bldg'],$buildings))
	{
		$addb=sprintf("INSERT INTO `buildings` (NAME) VALUES ('%s')",mysqli_real_escape_string($con,$_POST[bldg]));
		$addr=sprintf("INSERT INTO `rooms` (BUILDING, ROOM) VALUES ('%s','%s')",mysqli_real_escape_string($con,$_POST[bldg]),mysqli_real_escape_string($con,$_POST[room]));
		if (!mysqli_query($con,$addb)){die('Error: ' . mysqli_error($con));}
		if (!mysqli_query($con,$addr)){die('Error: ' . mysqli_error($con));}
		echo "Building and Room added<br>";
	}		
	else if(in_array($_POST['bldg'],$buildings) && !in_array($_POST['room'],$rooms))
	{
		$addr=sprintf("INSERT INTO `rooms` (BUILDING, ROOM) VALUES ('%s','%s')",mysqli_real_escape_string($con,$_POST[bldg]),mysqli_real_escape_string($con,$_POST[room]));
		if (!mysqli_query($con,$addr)){die('Error: ' . mysqli_error($con));}
		echo "Room added<br>";
	}
	$sql=sprintf("INSERT INTO comptest (HOSTNAME, BUILDING, ROOM, COMPNO, SERVICE, OS)
	VALUES ('%s','%s','%s','%s','%s','%s')",mysqli_real_escape_string($con,$_POST[hname]),mysqli_real_escape_string($con,$_POST[bldg]),mysqli_real_escape_string($con,$_POST[room]),mysqli_real_escape_string($con,$_POST[comp]),mysqli_real_escape_string($con,$_POST[srvc]),mysqli_real_escape_string($con,$_POST[os]));
	if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}
	echo "Record added<br>";
	mysqli_close($con);
}
include_once('footer.php');
?> 