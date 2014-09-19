<?php
$PageTitle="User Removed";
function customPageHeader(){?>
<?php }

session_start();

if(!isset($_SESSION['status']) || $_SESSION['status'] === 0)
{
	$_SESSION['message'] = "Not Logged In.";
	header("Location: ../admin/login.php");
	exit();
}

if($_SESSION['level'] == 0)
{
	include_once('config.php');
	if(strlen($_POST['id']) == 0){$_SESSION['message'] = "ERROR: NO USERID SPECIFIED.";}
	else
	{
		include_once('sqlconn.php');
		$result = mysqli_query($con,"DELETE FROM `" . $DB_USERINFO . "` WHERE ID=" . $_POST['id']);	
        if($result) 
        {
            $_SESSION['message'] = "User Removed";
        }
		mysqli_close($con);		
	}
    if($_POST['id'] == $_SESSION['id'])
    {
        header("Location: ../admin/logout.php");
        exit();
    }
	header("Location: ../admin/");
	exit();
}
else
{
	$_SESSION['message'] = "NOT AUTHORIZED.";
	header("Location: ../admin/login.php");
	exit();
}
include_once('footer.php');
?> 