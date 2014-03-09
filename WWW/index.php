<?php
$PageTitle="Computer Lab Availability";
function customPageHeader(){?>
<meta http-equiv="refresh" content="30" />
<?php }
include_once('header.php');
	include_once('./func/sqlconn.php');
	$bldg=$_GET['bldg'];
	$room=$_GET['room'];
	$id = "browse";
	$resultb = mysqli_query($con,"SELECT * FROM buildings ORDER BY NAME");
	$resultr = mysqli_query($con,sprintf("SELECT * FROM `rooms` WHERE `BUILDING`=\"%s\" ORDER BY ROOM",mysql_real_escape_string($bldg))); 
	if(strlen($bldg) > 0 || strlen($room) > 0) {$head = $bldg . " " . $room;}
	else {$head = "ALL COMPUTERS";}
	echo "<table border=\"0\"><tr><th id=\"head2\" width=200px><h2><center>Filter</center></h2></th><th id=\"head\" width=100%;><h2>Listing: $head</h2></th></tr><tr><td valign=top><form method=get name=f1 action='index.php'><ul id=$id><li><select name='bldg' onchange='this.form.submit()'>";	
	if(strlen($bldg) > 0){echo "<option value='$bldg'>$bldg</option>";}
	else{echo "<option value=''>Select Building</option>";}	
	while($row = mysqli_fetch_array($resultb)){echo "<option value=" . $row['NAME'] . ">" . $row['NAME'] . "</option>";}
	if(strlen($room > 0)) {$room_s = $room;}
	else {$room_s = 'Select Room';}
	echo "</select></li><li><select name='room' onchange='this.form.submit()'><option value=''>$room_s</option>";
	while($row = mysqli_fetch_array($resultr)){echo "<option value=" . $row['ROOM'] . ">" . $row['ROOM'] . "</option>";}
	echo "</select></li><noscript><input type=\"submit\" value=\"Submit\"></noscript></form><li><form action=\"index.php\"><input type=\"submit\" value=\"Reset\"></form></li></ul><td valign=top id=\"print\">";
	if(strlen($_GET['bldg']) > 0 && strlen($_GET['room']) == 0){$result = mysqli_query($con,sprintf("SELECT * FROM `comptest` WHERE `BUILDING`=\"%s\" ORDER BY ROOM ASC,COMPNO ASC,HOSTNAME ASC",mysql_real_escape_string($bldg)));}
	elseif (strlen($_GET['bldg']) > 0 && strlen($_GET['room']) > 0){$result = mysqli_query($con,sprintf("SELECT * FROM `comptest` WHERE `BUILDING`=\"%s\" and `ROOM`=\"%s\" ORDER BY COMPNO ASC,HOSTNAME ASC",mysql_real_escape_string($bldg),mysql_real_escape_string($room)));}	
	else{$result = mysqli_query($con,"SELECT * FROM `comptest` ORDER BY BUILDING ASC,ROOM ASC,COMPNO ASC");}	
	include_once('./func/printf.php');
	echo "</td></tr></table>";
	mysqli_close($con);
include_once('footer.php'); 
?>