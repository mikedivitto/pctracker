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
	</ul>
    </div>
    <div class="content">
