<?php
$PageTitle="Download Client";
function customPageHeader(){?>
<?php }
include_once('header.php');
?>
	<p>Client - Windows</p>
	<ul>
		<li>client - this will open in a console window and update the server saying the computer is unavailable (in use).</li>
		<li>run.vbs - this will allow the program to run in the background with no window (user does not know it is running).
		<ul><li>Can be useful if used as a login script.</li></ul></li>
		<li>Now has the Ability to Ping to a specified server.</li>
	</ul>
	<a href="../client/client2.zip"><p>Download Client</a></p>
<?php include_once('footer.php'); ?>