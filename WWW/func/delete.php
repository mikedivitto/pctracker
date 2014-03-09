<?php
$PageTitle="Record Deleted";
function customPageHeader(){?>
	<script type="text/JavaScript">
	<!--
	setTimeout("location.href = '../admin/index.php';",1500);
	-->
	</script>
<?php }
include_once('../admin/headernl.php');
if(strlen($_POST[id]) == 0){echo "ERROR: NO HOST SPECIFIED.";}
else
{
	include_once('sqlconn.php');
	$sql= sprintf("DELETE FROM `comptest` WHERE `ID`='%s'",mysql_real_escape_string($_POST['id']));	
	if (!mysqli_query($con,$sql)){die('Error: ' . mysqli_error($con));}	
	echo "Record Deleted";
	mysqli_close($con);
}
include_once('footer.php');
?> 