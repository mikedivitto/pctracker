<!doctype html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title><?= isset($PageTitle) ? $PageTitle : "Default Title"?></title>
    <link rel="stylesheet" type="text/css" href="../css/admin.css">
    <?php if (function_exists('customPageHeader')){customPageHeader();}?>
  </head>
  <body>
    <div class="header">
	<h1 align=center>Admin Console</h1>
	<ul id="menubar">
		<li><a href="index.php">Home</a></li>
		<li><a href="view.php">Status</a></li>
		<li><a href="add.php">Register</a></li>
		<li><a href="remove.php">Remove</a></li>
		<li><a href="detail.php">Detail</a></li>
		<li><a href="download.php">Download</a></li>
		<li><a href="../../phpMyAdmin">phpMyAdmin</a></li>
		<li><a href="../index.php">Exit Admin</a></li>
	</ul>
    </div>
    <div class="content">
