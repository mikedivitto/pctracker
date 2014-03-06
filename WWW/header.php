<!doctype html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title><?= isset($PageTitle) ? $PageTitle : "Default Title"?></title>
    <link rel="stylesheet" type="text/css" href="./css/main.css">
    <?php if (function_exists('customPageHeader')){customPageHeader();}?>
  </head>
  <body>
    <div class="header">
	<h1 align=center>Computer Lab Availability</h1>
	<ul id="menubar">
		<li><a href="index.php">Home</a></li>
		<li><a href="about.php">About</a></li>
	</ul>
    </div>
    <div class="content">