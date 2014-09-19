<?php
$PageTitle="About Openlabs";
function customPageHeader(){?>
<?php }
include_once('header.php');
?>

<div class="centered-panel">
	<div class="panel panel-default">
		<div class="panel-heading"><center><h1 class="panel-title">About Openlabs</h1></div>
		<div class="panel-body">
            <p>Openlabs is an Open Source Project created by Mike Divitto for the Computer Programming Club at SUNY New Paltz. The source is currently hosted on <a href="http://www.github.com/mikedivitto/openlabs">GitHub</a></p>
            
			<p>Included Features:</p>
			<ul>
				<li>Register, Edit, and Remove Computers</li>
                <li>Edit and Remove Buildings</li>
                <li>User Management inluding User Roles (Admin, Manager)</li>
				<li>Download Link for Client Software</li>
				<li>Reset All Data (Clear Database)</li>		
			</ul>
			<p>Recently Updated:</p>
			<ul>
				<li>User Mangement</li>
                <li>Improved User Role Capabilities</li>
			</ul>
			<p>To Do:</p>
			<ul>
				<li>Interface Cleanup</li>
			</ul>
		</div>	
	</div>
</div>

<?
include_once('footer.php'); ?>
