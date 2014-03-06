<?php
$PageTitle="Initial Setup";
function customPageHeader(){?>
<script type="text/JavaScript">
	<!--
	setTimeout("location.href = '../admin/index.php';",1500);
	-->
	</script>
<?php }
include_once('../admin/header.php');
include_once('../func/sqlconn.php');
	$sqla="CREATE TABLE comptest (ID INT NOT NULL AUTO_INCREMENT, HOSTNAME TEXT NOT NULL, OS TEXT NOT NULL, BUILDING TEXT NOT NULL, ROOM TEXT NOT NULL, COMPNO TEXT NOT NULL, TIMESTAMP TEXT, SERVICE INT NOT NULL, UNAME TEXT, PRIMARY KEY ( ID ))";
	$sqlb="CREATE TABLE buildings (NAME TEXT NOT NULL)";
	$sqlc="CREATE TABLE rooms (BUILDING TEXT NOT NULL, ROOM TEXT NOT NULL)";
	if (!mysqli_query($con,$sqla)){die('Error: ' . mysqli_error($con));}
	if (!mysqli_query($con,$sqlb)){die('Error: ' . mysqli_error($con));}
	if (!mysqli_query($con,$sqlc)){die('Error: ' . mysqli_error($con));}
	echo "Database Prepared";
	mysqli_close($con);
include_once('footer.php'); ?>