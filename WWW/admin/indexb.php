<?php

$html2 = '<p>Not all functions currently available. Use phpMyAdmin to perform actions not yet implemented.</p><br>
	<p>Client Software has been updated!! The software will now run natively in Windows without Python.<br>
	There is no longer a need for a server to be running at all times now.</p><br>
	<p>Included Features:</p>
	<ul>
		<li>Register New Computer</li>
		<li>Remove Computer</li>
		<li>Detail View, including ability to Update Info</li>
		<li>Download Link for Client Software</li>
		<li>Reset All Data (Clear Database)</li>		
	</ul>
	<p>Recently Updated:</p>
	<ul>
		<li>Admin Console is now Password Protected</li>
		<li>Added "Status" View (Lists all computers)</li>
		<li>The Menubar now does drop-down menus (to collapse some items)</li>
		<li>Modified Menubar to match original</li>
		<li>Added Reset All Function</li>
		<li>Implemented ID functionality to Update and Remove via Web</li>
		<li>Created a config.php file to store Database information (Username, Hostname, etc.)</li>
		<ul><li>Now there is no need to change information in all the php files, and it helps with security.</li></ul>
		<li>There is now a setup script to set up the Database (YAY!)</li>
	</ul>
	<p>To Do:</p>
	<ul>
		<li>Room and Building Management / Cleanup</li>
	</ul>';
	addslashes($html2);

?>