<?php

//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(-1);

$PageTitle="Computer Management";
function customPageHeader(){?>
<?php }
include_once('header.php');
?>
<style>
	.computer {
        border: 1px solid black;
        width: 120px;
        float: left;
        margin: 5px 5px 5px 5px;
        text-decoration: none;
        color: black;
        border-radius: 3px;
    }
    .serv0 {
        background-color: palegreen;
    }
    
    .serv1 {
     	background-color: #e8e8e8;   
    }
    .mybtn {
     	border: 1px solid black; 
        border-radius: 3px; 
        background-color: #ccc; 
        padding: 5px 5px 5px 5px; 
        margin: 5px 5px 5px 5px;
    }
</style>

<div class="modal fade" id="addComp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>  
          <h4 class="modal-title" id="myModalLabel">Add Computer</h4>
      </div>
      <div class="modal-body">	
          <form class="form-horizontal" role="form" action="../func/insert.php" method="post">
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label col-md-4">Hostname</label>
                  <div class="col-sm-9 col-md-8 col-lg-7">
                      <input class="form-control" id="inputEmail3" type="text" name="hname" autofocus required>
                  </div>
              </div>
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label col-md-4">OS</label>
                  <div class="col-sm-9 col-md-8 col-lg-7">
                      <input class="form-control" id="inputEmail3" type="text" name="os" required>
                  </div>
              </div>
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label col-md-4">Building</label>
                  <div class="col-sm-9 col-md-8 col-lg-7">
                      <input class="form-control" id="inputEmail3" type="text" name="bldg" required>
                  </div>
              </div>
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label col-md-4">Room</label>
                  <div class="col-sm-9 col-md-8 col-lg-7">
                      <input class="form-control" id="inputEmail3" type="text" name="room" required>
                  </div>
              </div>
              <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label col-md-4">Computer Number</label>
                  <div class="col-sm-9 col-md-8 col-lg-7">
                      <input class="form-control" id="inputEmail3" type="text" name="comp" required>
                  </div>
              </div>
              <div class="form-group">
					<label for="inputEmail3" class="col-sm-3 control-label col-md-4">Service Status</label>
					<div class="col-sm-9 col-md-8 col-lg-7">
						<select class="form-control" id="inputEmail3" type="text" name="srvc">
							<option value='0'>In Service</option>
							<option value='1'>Not In Service</option>
						</select>
					</div>
              </div>
      </div>
      <div class="modal-footer">
          <input class="btn btn-primary" type="submit" value="Submit" id="submitbutton">
          </form>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <button style="float: left; margin-top: -2px;" class="btn btn-success btn-xs" data-toggle="modal" data-target="#addComp"><span class="glyphicon glyphicon-plus"></span> Add</button>
        <center><h1 class="panel-title" style="margin-right: 50px;">Computers</h1></center>
    </div>
    <div class="panel-body">
        <div id="computers">
        </div>  
    </div>	
</div>

<script>
    $('.modal').on('hidden.bs.modal', function(){
        $(this).find('form')[0].reset();
    });
    $('.modal').on('shown.bs.modal', function() {
      $(this).find('[autofocus]').focus();
    });
    var url = "app/app.php";
    var data = $.parseJSON(
            $.ajax({
                url: url, 
                async: false,
                dataType: 'json'
            }).responseText
        );
    console.log(data);
    for (var key in data)
    {
        var comp = data[key];
        $("#computers").append("<div title='Building: " + comp.BUILDING + "\nRoom: " + comp.ROOM + "\nOS: " + comp.OS + "' style='' class='computer serv" + comp.SERVICE + "' id='" + comp.ID + "'>\
									<center>\
                                        <img src='../css/icon.png' alt='' style='width: 50%'>\
                                        <br>" + comp.BUILDING + "  <b><big>" + comp.COMPNO + "</big></b> " + comp.ROOM + "<br>\
                                        <a href='detail.php?hname=" + comp.HOSTNAME + "&ID=" + comp.ID + "'><span class='mybtn glyphicon glyphicon-pencil' aria-hidden='true' style=''></span></a>\
                                        <a href='confirm.php?hname=" + comp.HOSTNAME + "&id=" + comp.ID + "'><span class='mybtn glyphicon glyphicon-remove' aria-hidden='true'></span></a>\
    								</center>\
    							</div>");
    }
</script>
<? include_once('footer.php'); ?>
