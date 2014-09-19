<?php
$PageTitle="Reset All Data";
function customPageHeader(){?>
<?php }
include_once('header.php');

if($_SESSION['level'] != 0)
{
    $_SESSION['message'] = "NOT AUTHORIZED.";
	header("Location: ../admin/");
	exit();
}?>
<div class="centered-panel">
    <div class="panel panel-default">
        <div class="panel-heading"><center><h1 class="panel-title">Are you sure you want to reset?</h1></center></div>
        <div class="panel-body">
            <p>This will erase everything in the database.</p>
            <form action="../restr/reset.php"><input type="submit" value="Continue" id="submitbutton"></form>
        </div>	
    </div>
</div>

<?include_once('footer.php'); ?>
