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
	/*echo "<p>ID:  " . $_POST['id'] . "</p>";
	echo "<p>Hostname:  " . $_POST['hname'] . "</p>";
	echo "<p>Operating System:  " . $_POST['os'] . "</p>";
	echo "<p>Building: " . $_POST['bldg'] . "</p>";
	echo "<p>Room: " . $_POST['room'] . "</p>";
	echo "<p>Computer: " . $_POST['comp'] . "</p>";
	echo "<p>Service: " . $_POST['srvc'] . "</p>";
	echo "<p>Current Time: " . time() . "</p>";	*/
	$id = "\"" . $_POST['id'] . "\"";
	$hname = "\"" . $_POST['hname'] . "\"";
	$os = "\"" . $_POST['os'] . "\"";
	$bldg = "\"" . $_POST['bldg'] . "\"";
	$room = "\"" . $_POST['room'] . "\"";
	$comp = "\"" . $_POST['comp'] . "\"";
	$srvc = "\"" . $_POST['srvc'] . "\"";
	include_once('sqlconn.php');
	$query = "UPDATE `comptest` SET `OS`=" . $os . ",`BUILDING`=" . $bldg . ",`ROOM`=" . $room . ",`COMPNO`=" . $comp . ",`SERVICE`=" . $srvc . " WHERE `ID`=" . $id;	
	/*echo "<p>Sending Query: " . $query . "</p>";*/
	mysqli_query($con,$query);	
	mysqli_close($con);
include_once('footer.php');
?>
