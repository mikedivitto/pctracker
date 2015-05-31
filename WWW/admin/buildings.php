<?php
$PageTitle="Building Management";	
function customPageHeader(){?>
<?php }	
include_once('header.php');
include_once('../func/sqlconn.php');

if($_SESSION['level'] > 1)
{
	$_SESSION['message'] = "NOT AUTHORIZED.";
	header("Location: ../admin");
	exit();
}

if(isset($_POST['type']))
{
	if($_POST['type'] === "remv")
	{
		$bldg = $_POST['bldg'];
		$resulta = mysqli_query($con,sprintf("DELETE FROM `" . $DB_COMPUTERS . "` WHERE `BUILDING`=\"%s\"",mysqli_real_escape_string($con,$bldg)));
		$resultb = mysqli_query($con,sprintf("DELETE FROM `" . $DB_ROOMS . "` WHERE `BUILDING`=\"%s\"",mysqli_real_escape_string($con,$bldg)));
		$resultc = mysqli_query($con,sprintf("DELETE FROM `" . $DB_BUILDINGS . "` WHERE `NAME`=\"%s\"",mysqli_real_escape_string($con,$bldg)));
		$_SESSION['message'] = $bldg . " removed.";
		header("Location: ./");
		exit();
	}
	elseif($_POST['type'] === "edit")
	{
		$name = $_POST['bname'];
		$bldg = $_POST['bldg'];
		$resulta = mysqli_query($con,sprintf("UPDATE `" . $DB_BUILDINGS . "` SET `NAME`=\"%s\" WHERE `NAME`=\"%s\"",mysqli_real_escape_string($con,$name),mysqli_real_escape_string($con,$bldg)));
		$resultb = mysqli_query($con,sprintf("UPDATE `" . $DB_ROOMS . "` SET `BUILDING`=\"%s\" WHERE `BUILDING`=\"%s\"",mysqli_real_escape_string($con,$name),mysqli_real_escape_string($con,$bldg)));
		$resultb = mysqli_query($con,sprintf("UPDATE `" . $DB_COMPUTERS . "` SET `BUILDING`=\"%s\" WHERE `BUILDING`=\"%s\"",mysqli_real_escape_string($con,$name),mysqli_real_escape_string($con,$bldg)));
		$_SESSION['message'] = $bldg . " updated.";
		header("Location: ./");
		exit();
	}
	else
	{
		$_SESSION['message'] = "Invalid Request.";
		header("Location: ./");
		exit();
	}
}


if(isset($_GET['bldg']))
{
	if($_GET['req'] === "edit")
	{
		$bldg = $_GET['bldg'];
		$tmp = mysqli_query($con,sprintf("SELECT * FROM `" . $DB_ROOMS . "` WHERE `BUILDING`=\"%s\" ORDER BY ROOM ASC",mysqli_real_escape_string($con,$bldg)));
		$result = array();
		while ($row = mysqli_fetch_assoc($tmp)) {
			array_push($result, $row);	
		}
		$resultstr = "";
		foreach ($result as &$row)
		{
			$resultstr = $resultstr . "<tr><td>" . $row['ROOM'] . "</td><td><a href='rooms.php?bldg=" . $bldg . "&room=" . $row['ROOM'] . "&req=edit'>Edit</a></td><td><a href='rooms.php?bldg=" . $bldg. "&room=" . $row['ROOM'] . "&req=remv'>Remove</a></td></tr>";
		}
		?>
		<div class="centered-panel">
			<div class="panel panel-default">
				<div class="panel-heading"><center><h1 class="panel-title"><? echo $_GET['bldg']; ?></h1></center></div>
				<div class="panel-body">
					<form class="form-horizontal" role="form" action="buildings.php" method="post">
						<div class="form-group">
							<label for="inputEmail3" class="col-sm-3 control-label col-md-3">New Name</label>
							<div class="col-sm-9 col-md-8 col-lg-6">
								<input class="form-control" id="inputEmail3" type="text" name="bname" autofocus>
							</div>
						</div>
						<input type="hidden" name="type" value="edit">
						<input type="hidden" name="bldg" value="<?echo $bldg;?>">
						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-10">
								<input class="btn btn-default" type="submit" value="Submit" id="submitbutton">
							</div>
						</div>
					</form>
				</div>	
			</div>
		</div>
		<div class="centered-panel">
			<div class="panel panel-default">
				<div class="panel-heading"><center><h1 class="panel-title">ROOMS IN <? echo $_GET['bldg']; ?></h1></center></div>
				<div class="panel-body">
					<table class="table">
						<thead>
							<tr>
								<th>Room</th>
								<th colspan="2">Options</th>
							</tr>
						</thead>
						<tbody>
							<?php echo $resultstr; ?>
						</tbody>
					</table>
				</div>	
			</div>
		</div>
	<?
	}
	elseif($_GET['req'] === "remv")
	{
	?>
		<div class="centered-panel">
			<div class="panel panel-default">
				<div class="panel-heading"><center><h1 class="panel-title">Are you sure you want to remove <? echo $_GET['bldg']; ?>?</h1></center></div>
				<div class="panel-body">
					<form class="form-horizontal" role="form" action="buildings.php" method="post">
						<p>***This will also remove all Computers registered in this Building***</p>
						<input type="hidden" name="type" value="remv">
						<input type="hidden" name="bldg" value=<?php echo $_GET['bldg'];?>>
						<div class="form-group">
							<div class="col-sm-offset-0 col-sm-10">
								<input class="btn btn-default" type="submit" value="Confirm" id="submitbutton">
							</div>
						</div>
					</form>
				</div>	
			</div>
		</div>
	<?
	}
	else
	{
		$_SESSION['message'] = "Invalid Requestaxwax";
		header("Location: ./");
	}
}
else
{
	$sql = "SELECT * FROM " . $DB_BUILDINGS;
	$result = mysqli_query($con, $sql);
	$bldgsarr = array();
	while ($row = mysqli_fetch_assoc($result)) {array_push($bldgsarr, $row);}
	$resultstr = "";
	foreach ($bldgsarr as $row)
	{
		$resultstr = $resultstr . "<tr><td>" . $row['NAME'] . "</td><td><a href='buildings.php?bldg=" . $row['NAME'] . "&req=edit'>Edit</a></td><td><a href='buildings.php?bldg=" . $row['NAME'] . "&req=remv'>Remove</a></td></tr>";
	}
	?>
	<div class="centered-panel">
		<div class="panel panel-default">
			<div class="panel-heading"><center><h1 class="panel-title">ALL BUILDINGS</h1></center></div>
			<div class="panel-body">
				<table class="table table-responsive table-bordered">
					<thead>
						<tr>
							<th>Name</th>
							<th colspan="2">Options</th>
						</tr>
					</thead>
					<tbody>
					<?php echo $resultstr; ?>		
					</tbody>
				</table>
			</div>	
		</div>
	</div>
	<?
}
mysqli_close($con);	
include_once('footer.php');
?>