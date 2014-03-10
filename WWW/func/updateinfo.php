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
	include_once('sqlconn.php');
	$query = sprintf("UPDATE `comptest` SET `OS`=\"%s\",`BUILDING`=\"%s\",`ROOM`=\"%s\",`COMPNO`=\"%s\",`SERVICE`=\"%s\" WHERE `ID`=\"%s\"",
		mysqli_real_escape_string($con,$_POST['os']),mysqli_real_escape_string($con,$_POST['bldg']),
		mysqli_real_escape_string($con,$_POST['room']),mysqli_real_escape_string($con,$_POST['comp']),
		mysqli_real_escape_string($con,$_POST['srvc']),mysqli_real_escape_string($con,$_POST['id']));	
	mysqli_query($con,$query);	
	mysqli_close($con);
include_once('footer.php');
?>
