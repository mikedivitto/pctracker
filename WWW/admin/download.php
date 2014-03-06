<?php
$PageTitle="Download Client";
function customPageHeader(){?>
<?php }
include_once('header.php');
?>
	<p>New Client - Windows</p>
	<ul>
		<li>client - this will open in a console window and update the server saying the computer is unavailable (in use).</li>
		<li>run.vbs - this will allow the program to run in the background with no window (user does not know it is running).
		<ul><li>Can be useful if used as a login script.</li></ul></li>
		<li>**Fixed the issue where it would run with a relatively high CPU usage.</li>
	</ul>
	<p>DEPRECATED -- The client package contains the following:</p>
	<ul>
		<li>openlabs.py - Python-based client that runs in the background to update the server with the current status.</li>
		<li>addcomp.py - Python-based program that registers the computer. (Requires some user input)</li>
		<li>run.bat - Batch file for Windows to run the openlabs.py using the command prompt.</li>
		<ul>
			<li>Mainly used for run2.vbs, which runs the openlabs.py script with no window.</li>
		</ul>
		<li>run2.vbs - script to run the openlabs.py script in the background, so it does not interfere with the user.</li>
	</ul>
	<p>The python scripts were created with Python 2.7 and have been tested with Windows and Linux.</p><br>
	<a href="../client/openlabs.zip"><p>DEPRECATED -- Download Client</a></p>
	<a href="../client/client2.zip"><p>NEW DOWNLOAD (NATIVE CLIENT)</a></p>
<?php include_once('footer.php'); ?>