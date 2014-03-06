<?php
$PageTitle="About";
function customPageHeader(){?>
<?php }
include_once('header.php');
?>
	<p>Current Functions:</p>
	<ul>
		<li>View all the computers and their info / availability</li>
		<li>Browse by Building and by Room</li>
	</ul>
	<p>Recently Updated:</p>
	<ul>
		<li>Made Table Printout look nicer</li>
		<li>Added OS Type</li>
		<li>Password Protected the Admin Console</li>
		<li>Each Computer now has a unique ID (Need to implement this).</li>
		<li>Replaced Browse Function with a better alternative</li>
		<li>Moved Browse to be the index, removed "All Computers" link (unnecessary)</li>
		<li>Simplified Interface</li>
		<li>Fixed Drop Down refresh issue</li>
		<li>Added Reset Button</li>
		<li>Shows if computer is not in service instead of just unavailable.</li>
		<li>Added a New Paltz-esque Color Scheme</li>
		<li>Implement the new Unique ID feature (replaces management by Hostname)</li>
		<li>Count number of available computers i.e. "10 / 20 Available Computers"</li>
		<li>Convert the python based client to c/c++</li>
		<li>Clean Up Code... again.</li>
	</ul>
	<p>To Do:</p>
	<ul>
		<li>Filter By OS (Possibly)</li>
		<li>Implmement a web framework (Most likely Bootstrap or Foundation).</li>
		<li>Document the API</li>
	</ul>
	<p>A python script is used to update the server to provide an up to date availability of the computer.<br>Send me a message if you would like a copy of the python script.<br></p>
	<p><br>**Adding, removing, and updating functions are available through the Admin Portal**</p>
<?php include_once('footer.php'); ?>
