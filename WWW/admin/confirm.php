<?php
$PageTitle="Confirm Delete";
function customPageHeader(){?>
<?php }

if($_SESSION['level'] > 1)
{
    $_SESSION['message'] = "NOT AUTHORIZED.";
	header("Location: ../admin/");
	exit();
}

include_once('header.php');
	$tmp = $_POST['hname'];
	$tmpid = $_POST['id'];
	if(strlen($tmp) == 0){$tmp = $_GET['hname'];}
	if(strlen($tmpid) == 0){$tmpid = $_GET['id'];}
	$tmp = "\"" . $tmp . "\"";
	$tmpid = "\"" . $tmpid . "\"";
	?>
	<div class="centered-panel">
		<div class="panel panel-default">
			<div class="panel-heading"><center><h1 class="panel-title">Are you sure?</h1></center></div>
			<div class="panel-body">
				<?
					echo '<form action="../func/delete.php" method="post">';
					echo '<input type="hidden" name="id" value=' . $tmpid . ' readonly>Delete Hostname:   <input type="text" name="hname" value=' . $tmp . ' readonly><br><br>';
					echo '<input type="submit" value="Delete" id="submitbutton"></form><br><br>';
				?>
			</div>	
		</div>
	</div>
	<?
	
include_once('footer.php'); ?>
