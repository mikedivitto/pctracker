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
	<div id='cssmenu'>
		<ul>
  			<li><a href='index.php'><span>Home</span></a></li>
 			<li><a href='view.php'><span>Status</span></a></li>
			<li class='has-sub'><a href='#'><span>Computers</span></a>
				<ul>
					<li><a href='add.php'><span>Register</span></a></li>
					<li><a href='detail.php'><span>Detail</span></a></li>
					<li class='last'><a href='remove.php'><span>Remove</span></a></li>
				</ul>
			</li>
			<li><a href='download.php'><span>Download</span></a></li>
			<li class='has-sub'><a href='#'><span>Tools</span></a>
				<ul>
					<li><a href='../../phpMyAdmin'><span>phpMyAdmin</span></a></li>
					<li><a href='../restr/flush.php'><span>Flush Memcache</span></a></li>
					<li class='last'><a href='reset.php'><span>Reset All</span></a></li>
				</ul>
			</li>
			<li class='last'><a href='../index.php'><span>Exit</span></a></li>
		</ul>
	</div>    
   	</div>
    <div class="content">
