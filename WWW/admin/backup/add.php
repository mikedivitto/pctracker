<?php
$PageTitle="Register New Computer";
function customPageHeader(){?>
<?php }
include_once('header.php');
?>
<div class="panel panel-default centered-panel">
	<div class="panel-heading">
		<center><h1 class="panel-title">Register New Computer</h1></center>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" role="form" action="../func/insert.php" method="post">
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-3 control-label col-md-3">Hostname</label>
				<div class="col-sm-9 col-md-8 col-lg-6">
					<input class="form-control" id="inputEmail3" type="text" name="hname" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-3 control-label col-md-3">OS</label>
				<div class="col-sm-9 col-md-8 col-lg-6">
					<input class="form-control" id="inputEmail3" type="text" name="os">
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-3 control-label col-md-3">Building</label>
				<div class="col-sm-9 col-md-8 col-lg-6">
					<input class="form-control" id="inputEmail3" type="text" name="bldg">
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-3 control-label col-md-3">Room</label>
				<div class="col-sm-9 col-md-8 col-lg-6">
					<input class="form-control" id="inputEmail3" type="text" name="room">
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-3 control-label col-md-3">Computer Number</label>
				<div class="col-sm-9 col-md-8 col-lg-6">
					<input class="form-control" id="inputEmail3" type="text" name="comp">
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-3 control-label col-md-3">Service Status</label>
				<div class="col-sm-9 col-md-8 col-lg-6">
					<input class="form-control" id="inputEmail3" type="text" name="srvc">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-3 col-sm-10">
					<input class="btn btn-default" type="submit" value="Submit" id="submitbutton">
				</div>
			</div>
		</form>
	</div>
</div>
<?php include_once('footer.php'); ?>
