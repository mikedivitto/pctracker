<?php
$PageTitle="Reset All Data";
function customPageHeader(){?>
<?php }
include_once('header.php');
	echo "<h2>Are you sure you want to reset?</h2><br><p>This will erase everything in the database.</p><br>";
	echo "<form action=\"../restr/reset.php\"><input type=\"submit\" value=\"Continue\" id=\"submitbutton\"></form>";
include_once('footer.php'); ?>
