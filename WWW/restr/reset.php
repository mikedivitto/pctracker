<?php
$PageTitle="Reset All";
function customPageHeader(){?>
<script type="text/JavaScript">
	<!--
	setTimeout("location.href = '../admin/index.php';",1500);
	-->
	</script>
<?php }
include_once('../admin/header.php');
include_once('../func/sqlconn.php');
	$sqla="DELETE FROM `buildings` WHERE 1";
	$sqlb="DELETE FROM `comptest` WHERE 1";
	$sqlc="DELETE FROM `rooms` WHERE 1";
	if (!mysqli_query($con,$sqla)){die('Error: ' . mysqli_error($con));}
	if (!mysqli_query($con,$sqlb)){die('Error: ' . mysqli_error($con));}
	if (!mysqli_query($con,$sqlc)){die('Error: ' . mysqli_error($con));}
	echo "ALL DATA ERASED";
	mysqli_close($con);
include_once('footer.php'); ?>