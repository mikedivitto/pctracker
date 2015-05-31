<?php
$PageTitle="Change Password";
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
if($_SESSION['level'] < 2)
{
	include_once('sqlconn.php');
    if ($_POST['pwd1'] == "")
    {
        $_SESSION['message'] = "Cannot have a blank password.";
        header("Location: ../admin/cpwd.php");
        exit();
    }
    else
    {
        $quer = sprintf("SELECT * FROM " . $DB_USERINFO . " WHERE `ID`=" . $_SESSION['id']);
        $res = mysqli_query($con, $quer);
        $tmp = mysqli_fetch_array($res);
        if (crypt($_POST['pwd0'], $tmp['PASSWORD']) != $tmp['PASSWORD'])
        {
            $_SESSION['message'] = "Passwords do not match.";
            header("Location: ../admin/cpwd.php");
            exit();
        }
        else
        {
            $query = sprintf("UPDATE `" . $DB_USERINFO . "` SET `PASSWORD`=\"%s\" WHERE `ID`=\"%s\"",
            crypt(mysqli_real_escape_string($con,$_POST['pwd1'])),mysqli_real_escape_string($con,$_SESSION['id']));
        }
    }
	mysqli_query($con,$query);	
	mysqli_close($con);
	header("Location: ../admin/logout.php");
	exit();
}
else
{
	$_SESSION['message'] = "NOT AUTHORIZED.";
	header("Location: ../admin/");
	exit();
}
include_once('footer.php');
?>
