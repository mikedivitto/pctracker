<?php
$PageTitle="Register New Computer";
function customPageHeader(){?>
<?php }
include_once('header.php');
?>
	<h1>Register New Computer</h1>
	<p>Use this form to add a computer to the database</p><br>
	<form action="../func/insert.php" method="post">
	Hostname:        <input type="text" name="hname" autofocus><br>
	OS:		 <input type="text" name="os"><br>
	Building:        <input type="text" name="bldg"><br>
	Room:            <input type="text" name="room"><br>
	Computer Number: <input type="text" name="comp"><br>
	Service Status: (Enter 0 By Default)<input type="text" name="srvc"> <br><br>
	<input type="submit" value="Submit" id="submitbutton">
	</form>
<?php include_once('footer.php'); ?>
