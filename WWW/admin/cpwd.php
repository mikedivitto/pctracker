<?php
$PageTitle="User Management";	
function customPageHeader(){?>
<?php }	
include_once('header.php');


if($_SESSION['level'] > 1)
{
	$_SESSION['message'] = "Not Authorized!";
	header("Location: index.php");
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
<div class="centered-panel">
    <div class="panel panel-default">
        <div class="panel-heading"><center><h1 class="panel-title">Change Password</h1></center></div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" action="../func/cpwd.php" method="post">
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label col-md-3">Old Password</label>
                    <div class="col-sm-9 col-md-8 col-lg-6">
                        <input class="form-control" id="pwd0" type="password" name="pwd0" value="" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label col-md-3">New Password</label>
                    <div class="col-sm-9 col-md-8 col-lg-6">
                        <input class="form-control" id="pwd1" type="password" name="pwd1" value="" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label col-md-3">Confirm New</label>
                    <div class="col-sm-9 col-md-8 col-lg-6">
                        <input class="form-control" id="pwd2" type="password" name="pwd2" value="" onkeyup="checkPass(); return false;">
                        <span id="confirmMessage" class="confirmMessage"></span>
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
?>