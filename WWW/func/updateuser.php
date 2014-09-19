<?php
$PageTitle="Update User";
function customPageHeader(){?>
<?php }

session_start();
include_once('config.php');
if(!isset($_SESSION['status']) || $_SESSION['status'] === 0)
{
	$_SESSION['message'] = "Not Logged In.";
	header("Location: ../admin/login.php");
	exit();
}
if($_SESSION['level'] == 0)
{
	include_once('sqlconn.php');
    if ($_POST['pwd1'] == "")
    {
        $query = sprintf("UPDATE `" . $DB_USERINFO . "` SET `NICKNAME`=\"%s\",`LEVEL`=\"%s\" WHERE `ID`=\"%s\"",
		mysqli_real_escape_string($con,$_POST['nname']),
		mysqli_real_escape_string($con,$_POST['level']),mysqli_real_escape_string($con,$_POST['id']));
    }
    else
    {
        $query = sprintf("UPDATE `" . $DB_USERINFO . "` SET `PASSWORD`=\"%s\",`NICKNAME`=\"%s\",`LEVEL`=\"%s\" WHERE `ID`=\"%s\"",
		crypt(mysqli_real_escape_string($con,$_POST['pwd1'])),mysqli_real_escape_string($con,$_POST['nname']),
		mysqli_real_escape_string($con,$_POST['level']),mysqli_real_escape_string($con,$_POST['id']));
    }
	mysqli_query($con,$query);	
	mysqli_close($con);
    if($_POST['id'] == $_SESSION['id'])
    {
        header("Location: ../admin/logout.php");
        exit();
    }
	$_SESSION['message'] = "User Updated";
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
