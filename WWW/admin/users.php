<?php
$PageTitle="User Management";	
function customPageHeader(){?>
<?php }	
include_once('header.php');
include_once('../func/sqlconn.php');

if($_SESSION['level'] != 0)
{
	$_SESSION['message'] = "Not Authorized!";
	header("Location: index.php");
	exit();
}

$tmp = mysqli_query($con,"SELECT * FROM `" . $DB_USERINFO . "`");
$result = array();
while ($row = mysqli_fetch_assoc($tmp)) {
	array_push($result, $row);	
}
$resultstr = "";
foreach ($result as &$row)
{
    if($_SESSION['level'] == 0 /*or $_SESSION['email'] == $row['EMAIL']*/)
	{
	$resultstr = $resultstr . "<tr><td><big>" . $row['EMAIL'] . "</big></td><td><a class='btn btn-warning btn-xs' href='users.php?req=edit&id=" . $row['ID'] . "'>Edit</a></td><td><a class='btn btn-danger btn-xs' href='users.php?req=remv&id=" . $row['ID'] . "&nname=" . $row['NICKNAME'] . "'>Remove</a></td></tr>";
	}
}


if ($_GET['req'] == 'remv')
{
    ?>
    <div class="centered-panel">
		<div class="panel panel-default">
			<div class="panel-heading"><center><h1 class="panel-title">Delete User</h1></center></div>
			<div class="panel-body">
				<?
					echo '<form action="../func/rmuser.php" method="post">';
					echo '<input type="hidden" name="id" value=' . $_GET['id'] . ' readonly>Delete User:   <input type="text" name="uname" value="' . $_GET['nname'] . '" readonly><br><br>';
					echo '<input type="submit" value="Delete" id="submitbutton"></form><br><br>';
				?>
			</div>	
		</div>
	</div>
    <?
    quit();
}
elseif ($_GET['req'] == 'edit')
{    
    $tmp= $_GET['id'];		
	$result = mysqli_query($con,sprintf("SELECT * FROM `" . $DB_USERINFO . "` WHERE `ID`=\"%s\"",mysqli_real_escape_string($con,$tmp)));		
	$row = mysqli_fetch_array($result);	
	?>
    <script>
        function checkPass()
        {
            //Store the password field objects into variables ...
            var pass1 = document.getElementById('pwd1');
            var pass2 = document.getElementById('pwd2');
            //Store the Confimation Message Object ...
            var message = document.getElementById('confirmMessage');
            //Set the colors we will be using ...
            var goodColor = "#66cc66";
            var badColor = "#ff6666";
            //Compare the values in the password field 
            //and the confirmation field
            if(pass1.value == pass2.value){
                //The passwords match. 
                //Set the color to the good color and inform
                //the user that they have entered the correct password 
                pass2.style.backgroundColor = goodColor;
                message.style.color = goodColor;
                message.innerHTML = "Passwords Match!"
            }else{
                //The passwords do not match.
                //Set the color to the bad color and
                //notify the user.
                pass2.style.backgroundColor = badColor;
                message.style.color = badColor;
                message.innerHTML = "Passwords Do Not Match!"
            }
        }  
    </script>
	<div class="centered-panel">
		<div class="panel panel-default">
			<div class="panel-heading"><center><h1 class="panel-title">Detail for User: <?echo $row['NICKNAME'];?></h1></center></div>
			<div class="panel-body">
				<form class="form-horizontal" role="form" action="../func/updateuser.php" method="post">
					<input type="hidden" name="id" value=<?php echo $tmp; ?> readonly>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label col-md-3">Username</label>
						<div class="col-sm-9 col-md-8 col-lg-6">
							<input class="form-control" id="inputEmail3" type="text" name="uname" value="<?php echo $row['EMAIL']; ?>" readonly>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label col-md-3">Password</label>
						<div class="col-sm-9 col-md-8 col-lg-6">
							<input class="form-control" id="pwd1" type="password" name="pwd1" value="" >
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label col-md-3">Confirm</label>
						<div class="col-sm-9 col-md-8 col-lg-6">
							<input class="form-control" id="pwd2" type="password" name="pwd2" value="" onkeyup="checkPass(); return false;">
                            <span id="confirmMessage" class="confirmMessage"></span>
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label col-md-3">Nickname</label>
						<div class="col-sm-9 col-md-8 col-lg-6">
							<input class="form-control" id="inputEmail3" type="text" name="nname" value="<?php echo $row['NICKNAME']; ?>">
						</div>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-3 control-label col-md-3">User Level</label>
						<div class="col-sm-9 col-md-8 col-lg-6">
							<select class="form-control" id="inputEmail3" type="text" name="level">
                                <option value='0' <? if($row['LEVEL'] == 0) echo "selected"; ?></option>Administrator</option>
                                <option value='1' <? if($row['LEVEL'] == 1) echo "selected"; ?>>Manager</option>
                                <option value='2' <? if($row['LEVEL'] == 2) echo "selected"; ?>>User</option>
                            </select>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-10">
							<input class="btn btn-default" type="submit" value="Update" id="submitbutton">
						</div>
					</div>
				</form>			
			</div>	
		</div>
	</div>	
<?
    include_once('footer.php');
    exit();

}
?>

<script>
    function checkPass()
    {
        //Store the password field objects into variables ...
        var pass1 = document.getElementById('pwd1');
        var pass2 = document.getElementById('pwd2');
        //Store the Confimation Message Object ...
        var message = document.getElementById('confirmMessage');
        //Set the colors we will be using ...
        var goodColor = "#66cc66";
        var badColor = "#ff6666";
        //Compare the values in the password field 
        //and the confirmation field
        if(pass1.value == pass2.value){
            //The passwords match. 
            //Set the color to the good color and inform
            //the user that they have entered the correct password 
            pass2.style.backgroundColor = goodColor;
            message.style.color = goodColor;
            message.innerHTML = "Passwords Match!"
        }else{
            //The passwords do not match.
            //Set the color to the bad color and
            //notify the user.
            pass2.style.backgroundColor = badColor;
            message.style.color = badColor;
            message.innerHTML = "Passwords Do Not Match!"
        }
    }  
</script>

<div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Add New User</h4>
      </div>
      <div class="modal-body">
          <form class="form-horizontal" role="form" action="../func/adduser.php" method="post">
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-3 control-label col-md-3">Username</label>
				<div class="col-sm-9 col-md-8 col-lg-6">
					<input class="form-control" id="newEmail" type="text" name="uname" autofocus>
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-3 control-label col-md-3">Password</label>
				<div class="col-sm-9 col-md-8 col-lg-6">
					<input class="form-control" id="pwd1" type="password" name="pwd1">
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-3 control-label col-md-3">Confirm</label>
				<div class="col-sm-9 col-md-8 col-lg-6">
					<input class="form-control" id="pwd2" type="password" name="pwd2" onkeyup="checkPass(); return false;">
                    <span id="confirmMessage" class="confirmMessage"></span>
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-3 control-label col-md-3">Nickname</label>
				<div class="col-sm-9 col-md-8 col-lg-6">
					<input class="form-control" id="inputEmail3" type="text" name="name">
				</div>
			</div>
			<div class="form-group">
				<label for="inputEmail3" class="col-sm-3 control-label col-md-3">User Level</label>
				<div class="col-sm-9 col-md-8 col-lg-6">
                    <select class="form-control" id="inputEmail3" type="text" name="level">
                        <option value='0'>Administrator</option>
                        <option value='1'>Manager</option>
                        <option value='2'>User</option>
                    </select>
				</div>
			</div>		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input class="btn btn-default" type="submit" value="Submit" id="submitbutton">
          </form>
      </div>
    </div>
  </div>
</div>

<div class="centered-panel">
	<div class="panel panel-default">
		<div class="panel-heading"><center><h1 class="panel-title">Users</h1></center></div>
		<div class="panel-body">
            <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#addUser"><span class="glyphicon glyphicon-plus"></span> Add User</button><br>
			<table class="table">
				<thead>
					<tr>
						<th>Username</th>
						<th colspan="2">Options</th>
					</tr>
				</thead>
				<tbody>
					<?php echo $resultstr; ?>
				</tbody>
			</table>
		</div>	
        <div class="panel-footer">Note: Editing or Removing the Current User will Force A Log Off</div>
	</div>
</div>


<?
include_once('footer.php');
?>