<?php
include_once('../../func/config.php');
session_start();

if(!isset($_SESSION['status']) || $_SESSION['status'] === 0)
{
	header("Location: ../login.php");
	exit();
}

$timeh = time();

if($_SESSION['timeout'] > ($timeh + 1800))
{
	header("Location: ../logout.php");
	$_SESSION['message'] = "User timed out (30 minutes)";
	exit();
}
else
{
	$_SESSION['timeout'] = $timeh;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Reservation System</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/redmond/jquery-ui.css">
    <link rel="stylesheet" href="addons/jquery.timepicker.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script src="addons/jquery.timepicker.min.js"></script>
    <link href="../../css/dashboard.css" rel="stylesheet">
</head>

    <!--
<body>

    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <a class="navbar-brand" href=".">Library Reservation System</a>
            <p class="navbar-text navbar-right"><a href="?action=admin" class="navbar-link">Admin</a></p>
        </div>
    </nav>
    <div class="container">-->
    
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
			<li><a href="../index.php">Status</a></li>
            <li><a href="../logout.php">Logout</a></li>
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
          <ul class="nav nav-sidebar nav-pills nav-stacked">
            <li><a href="index.php">Admin Home</a></li>
            <li><a href="../" target="_blank">User Home</a></li>
            		      
          </ul>
            <h4>Reservations</h4>
            <ul class="nav nav-sidebar nav-pills nav-stacked">
                <li><a href="/~divittom/pctracker/admin/resapp/?action=admin">Manage Reservations</a></li>
                <li><a href="/~divittom/pctracker/admin/resapp/">Schedule a Reservation</a></li>
            </ul>
    		  <h4>Management</h4>
          <ul class="nav nav-sidebar nav-pills nav-stacked">
            <li <? if (basename($_SERVER['PHP_SELF']) == "cmanage.php") echo "class='active'"; ?>><a href="../cmanage.php">Computers</a></li>
            <?php if($_SESSION['level'] < 2) { echo '<li '; if (basename($_SERVER['PHP_SELF']) == "buildings.php" or basename($_SERVER['PHP_SELF']) == "rooms.php") echo "class='active'"; echo'><a href="../buildings.php">Buildings</a></li>';} ?>
            <?php if($_SESSION['level'] == 0) {echo '<li '; if (basename($_SERVER['PHP_SELF']) == "users.php") echo "class='active'"; echo '><a href="../users.php">Users</a></li>';} ?>
          </ul>
		      <h4>Tools</h4>
          <ul class="nav nav-sidebar nav-pills nav-stacked">
              <? if($_SESSION['level'] < 2) { echo '<li '; if (basename($_SERVER['PHP_SELF']) == "cpwd.php") echo "class='active'"; echo'><a href="../cpwd.php">Change Password</a></li>';} ?>
              	
            <?php if($_SESSION['level'] == 0) echo '<li><a href="' . $OL_PHPMYADMIN . '" target="_blank">phpMyAdmin</a></li>'; ?>
            <?php if($_SESSION['level'] == 0) echo '<li><a href="../../restr/flush.php">Flush Memcache</a></li>'; ?>
            <?php if($_SESSION['level'] == 0) echo '<!--<li><a href="../reset.php">Reset All</a></li>-->'; ?>
              <li <? if (basename($_SERVER['PHP_SELF']) == "download.php") echo "class='active'"; ?>><a href="../download.php">Download</a></li>
            <li <? if (basename($_SERVER['PHP_SELF']) == "about.php") echo "class='active'"; ?>><a href="../about.php">About</a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<?php  if(isset($_SESSION['message'])) { echo '<div class="alert alert-danger">' . $_SESSION['message'] . '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> </div>';} unset($_SESSION['message']); ?>