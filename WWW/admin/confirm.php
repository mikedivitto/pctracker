<?php
$PageTitle="Confirm Delete";
function customPageHeader(){?>
<?php }
include_once('header.php');
	$tmp = $_POST['hname'];
	$tmpid = $_POST['id'];
	if(strlen($tmp) == 0){$tmp = $_GET['hname'];}
	if(strlen($tmpid) == 0){$tmpid = $_GET['id'];}
	$tmp = "\"" . $tmp . "\"";
	$tmpid = "\"" . $tmpid . "\"";
	echo '<h2>Are you sure?</h2><br><form action="../func/delete.php" method="post">';
	echo 'ID:   <input type="text" name="id" value=' . $tmpid . ' readonly>Delete Hostname:   <input type="text" name="hname" value=' . $tmp . ' readonly><br><br>';
	echo '<input type="submit" value="Delete" id="submitbutton"></form><br><br>';
include_once('footer.php'); ?>
