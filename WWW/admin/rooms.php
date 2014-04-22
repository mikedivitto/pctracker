<?php
$PageTitle="Building Management";	
function customPageHeader(){?>
<?php }	
include_once('header.php');
include_once('../func/sqlconn.php');

if(!(isset($_GET['req']) || isset($_POST['type'])))
{
	$_SESSION['message'] = "Invalid Request";
	header("Location: ./");
	exit();
}

if($_POST['type'] === "edit")
{
	$bldg = $_POST['bldg'];
	$room = $_POST['room'];
	$name = $_POST['rname'];
	$resulta = mysqli_query($con,sprintf("UPDATE `" . $DB_ROOMS . "` SET `ROOM`=\"%s\" WHERE `BUILDING`=\"%s\" AND `ROOM`=\"%s\"",mysqli_real_escape_string($con,$name),mysqli_real_escape_string($con,$bldg),mysqli_real_escape_string($con,$room)));
	$resultb = mysqli_query($con,sprintf("UPDATE `" . $DB_COMPUTERS . "` SET `ROOM`=\"%s\" WHERE `BUILDING`=\"%s\" AND `ROOM`=\"%s\"",mysqli_real_escape_string($con,$name),mysqli_real_escape_string($con,$bldg),mysqli_real_escape_string($con,$room)));
	$_SESSION['message'] = $bldg . " " . $room . " updated.";
	header("Location: ./");
	exit();
}
elseif($_POST['type'] === "remv")
{
	$bldg = $_POST['bldg'];
	$room = $_POST['room'];
	$resulta = mysqli_query($con,sprintf("DELETE FROM `" . $DB_ROOMS . "` WHERE `BUILDING`=\"%s\" AND `ROOM`=\"%s\"",mysqli_real_escape_string($con,$bldg),mysqli_real_escape_string($con,$room)));
	$resultb = mysqli_query($con,sprintf("DELETE FROM `" . $DB_COMPUTERS . "` WHERE `BUILDING`=\"%s\" AND `ROOM`=\"%s\"",mysqli_real_escape_string($con,$bldg),mysqli_real_escape_string($con,$room)));
	$_SESSION['message'] = $bldg . " " . $room . " deleted.";
	header("Location: ./");
	exit();
}


if($_GET['req'] === "remv")
{
?>
	<div class="centered-panel">
		<div class="panel panel-default">
			<div class="panel-heading"><center><h1 class="panel-title">Are you sure you want to remove <? echo $_GET['bldg'] . " " . $_GET['room']; ?>?</h1></center></div>
			<div class="panel-body">
				<form class="form-horizontal" role="form" action="rooms.php" method="post">
					<p>***This will also remove all Computers registered in this Room***</p>
					<input type="hidden" name="type" value="remv">
					<input type="hidden" name="bldg" value=<?php echo $_GET['bldg'];?>>
					<input type="hidden" name="room" value=<?php echo $_GET['room'];?>>
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
exit();
}
elseif($_GET['req'] === "edit")
{
	$bldg = $_GET['bldg'];
	$room = $_GET['room'];
	$tmp = mysqli_query($con,sprintf("SELECT * FROM `" . $DB_COMPUTERS . "` WHERE `BUILDING`=\"%s\" AND `ROOM`=\"%s\" ORDER BY ROOM ASC, COMPNO ASC",mysqli_real_escape_string($con,$bldg),mysqli_real_escape_string($con,$room)));
	$result = array();
	while ($row = mysqli_fetch_assoc($tmp)) {
		array_push($result, $row);	
	}
	$resultstr = "";
	foreach ($result as &$row)
	{
		$resultstr = $resultstr . "<tr><td>" . $row['COMPNO'] . "</td><td>" . $row['HOSTNAME'] . "</td><td><a href='detail.php?hname=" . $row['HOSTNAME'] . "&ID=" . $row['ID'] . "'>Detail</a></td><td><a href='confirm.php?hname=" . $row['HOSTNAME'] . "&id=" . $row['ID'] . "'>Remove</a></td></tr>";
	}
	?>
	<div class="centered-panel">
		<div class="panel panel-default">
			<div class="panel-heading"><center><h1 class="panel-title"><? echo $bldg . " " . $room; ?></h1></center></div>
			<div class="panel-body">
				<form class="form-horizontal" role="form" action="rooms.php" method="post">
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label col-md-3">New Name</label>
						<div class="col-sm-9 col-md-8 col-lg-6">
							<input class="form-control" id="inputEmail3" type="text" name="rname" autofocus>
						</div>
					</div>
					<input type="hidden" name="type" value="edit">
					<input type="hidden" name="bldg" value="<?echo $bldg;?>">
					<input type="hidden" name="room" value="<?echo $room;?>">
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
			<div class="panel-heading"><center><h1 class="panel-title">COMPUTERS IN <? echo $bldg . " " . $room; ?></h1></center></div>
			<div class="panel-body">
				<table class="table">
					<thead>
						<tr>
							<th>No.</th>
							<th>Computer</th>
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
exit();
}

$_SESSION['message'] = "Invalid Request";
header("Location: ./");
exit();


include_once('footer.php');
?>