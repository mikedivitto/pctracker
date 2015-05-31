<?php
$PageTitle="Coputer Management";	
function customPageHeader(){?>
<?php }	
include_once('header.php');
?>
<div class="centered-panel">
	<div class="panel panel-default">
		<div class="panel-heading"><center><h1 class="panel-title">Computer Tools</h1></center></div>
		<div class="panel-body">
			<? if ($_SESSION['level'] < 2) echo'<a href="add.php">Register Computer</a><br>'; ?>
			<a href="detail.php">Computer Detail</a><br>
			<? if ($_SESSION['level'] < 2) echo'<a href="remove.php">Remove Computer</a><br>'; ?>
		</div>	
	</div>
</div>
<?
include_once('footer.php');
?>
