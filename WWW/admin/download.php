<?php
$PageTitle="Download Client";
function customPageHeader(){?>
<?php }
include_once('header.php');
?>
<div class="centered-panel">
	<div class="panel panel-default">
		<div class="panel-heading"><center><h1 class="panel-title">Client Download</h1></center></div>
		<div class="panel-body">
			<p>New Client</p>
			<ul>
				<li>setup.exe - Extracts required files to C:\openlabs and registers the client in the Task Scheduler to run when any user logs in.</li>
			</ul>
			<p>Client - Windows [DEPRECATED]</p>
			<ul>
				<li>client - this will open in a console window and update the server saying the computer is unavailable (in use).</li>
				<li>run.vbs - this will allow the program to run in the background with no window (user does not know it is running).
				<ul><li>Can be useful if used as a login script.</li></ul></li>
				<li>Now has the Ability to Ping to a specified server.</li>
			</ul>
			<a href="../client/setup.exe"><p>Download Client [3/28/2014]</a></p>
			<a href="../client/client2.zip"><p>Download Client - DEPRECATED</a></p>
		</div>	
	</div>
</div>
<?php include_once('footer.php'); ?>