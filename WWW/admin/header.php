<?php
include_once('../func/config.php');
session_start();

if(!isset($_SESSION['status']) || $_SESSION['status'] === 0)
{
	header("Location: ./login.php");
	exit();
}

$timeh = time();

if($_SESSION['timeout'] > ($timeh + 1800))
{
	header("Location: ./logout.php");
	$_SESSION['message'] = "User timed out (30 minutes)";
	exit();
}
else
{
	$_SESSION['timeout'] = $timeh;
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($PageTitle) ? $PageTitle : "Default Title"?></title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/dashboard.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">Admin Console</a>
        </div>		
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <!--<li><a href="#">Settings</a></li>-->
            <li><a href="#">Welcome, <?php echo $_SESSION['nickname']; ?></a></li>
			<li><a href="index.php">Status</a></li>
            <li><a href="logout.php">Logout</a></li>
          </ul>
          <!--form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>-->
		  
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li><a href="index.php">Admin Home</a></li>
            <li><a href="../" target="_blank">User Home</a></li>
            <li><a href="download.php">Download</a></li>			      
          </ul>
    		  <h4>Management</h4>
          <ul class="nav nav-sidebar">
            <li><a href="chome.php">Computers</a></li>
            <li><a href="buildings.php">Buildings</a></li>
            <li><a href="users.php">Users</a></li>
          </ul>
		      <h4>Tools</h4>
          <ul class="nav nav-sidebar">
            <li><a href="../../phpMyAdmin/" target="_blank">phpMyAdmin</a></li>
            <li><a href="../restr/flush.php">Flush Memcache</a></li>
            <li><a href="reset.php">Reset All</a></li>
            <li><a href="about.php">About</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<?php  if(isset($_SESSION['message'])) { echo '<div class="alert alert-danger">' . $_SESSION['message'] . '</div>';} unset($_SESSION['message']); ?>
          