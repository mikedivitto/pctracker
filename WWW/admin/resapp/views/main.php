<? if (!isset($_REQUEST['date'])) {$date = date('Y-m-d');} else {$date = $_REQUEST['date'];} ?>

<div class="modal fade" id="addComp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <!--<button type="reset" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button> -->
                <h4 class="modal-title" id="myModalLabel">Create Reservation</h4>
            </div>
            <div class="modal-body">
                <form action="res.php" class="form-horizontal" id="addForm">
                    <input type=hidden name=action value=create />
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="Name" name="name" required autofocus>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Student ID</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="Student ID" name="stid" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="Email" name="emal" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Phone</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="Phone" name="phon" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-md-2 col-md-offset-1 control-label">Room</label>
                        <div class="col-md-3">
                            <select class="form-control" id="inputEmail3" placeholder="Room" name="room" required>
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                                <option>6</option>
                                <option>7</option>
                                <option>8</option>
                                <option>9</option>
                                <option>10</option>
                            </select>
                        </div>
                        <label for="inputEmail3" class="col-md-2 control-label">Start</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="starttime" placeholder="Start" name="starttm" required>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-md-2 col-md-offset-1 control-label">Date</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control datepicker" id="datepicker1" placeholder="Date" name="date" required readonly="readonly" style="background-color:#FFFFFF">
                        </div>
                        <label for="inputEmail3" class="col-md-2 control-label">End</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="endtime" placeholder="End" name="endtm" required>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <input class="btn btn-primary" type="submit" value="Submit" id="submitbutton">
                <button type="reset" class="btn btn-default" data-dismiss="modal" onclick="document.getElementById('addForm').reset();">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading"><center>Select a Date</center></div>
            <div class="panel-body">
                <center>
                <div id="datepicker"></div>
                    </center>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading"><button style="float: left; margin-top: -2px;" class="btn btn-success btn-xs" data-toggle="modal" data-target="#addComp"><span class="glyphicon glyphicon-plus"></span> Add</button><center style="margin-right: 45px;">Reservations for <?=date('m/d/Y', strtotime($date));?></center></div>
            <div class="panel-body">
                <div id="data"></div>
            </div>
        </div>
    </div>
</div>
<form id="subForm" action=.>
    <input type=hidden name=action value=frontpage />
    <input type=hidden id="formDate" name=date />
</form>
<script>
    $("#datepicker").datepicker({dateFormat: "yy-mm-dd", defaultDate: new Date(<? echo date("Y,m-1,d", strtotime($date)); ?>), onSelect: function(text, inst){ $( '#formDate' ).val(text); $( '#subForm' ).submit();}});
    $.ajax({
        url: 'http://cs.newpaltz.edu/~divittom/resapp/res.php?action=listtoday&date=<?=$date?>',
        type: 'POST',
        dataType: "text",
        success: function (response) {
            $('#data').append(response);
        }
    });
    $("#datepicker1").datepicker({
        dateFormat: "yy-mm-dd"
    });
    $("#starttime").timepicker({
        'scrollDefault': 'now',
        'minTime': '9:00am',
        'maxTime': '9:00pm'
    });
    $("#endtime").timepicker({
        'scrollDefault': 'now',
        'minTime': '9:00am',
        'maxTime': '9:00pm'
    });
</script>

<!--
<table>
    <tr>
        <th>Room</th>
        <th><center>Date</center></th>
    </tr>
    <tr>
        <td>
            Room 1
        </td>
        <td>
            <div style="width: 40px; float: left; background-color: red; margin-left: 1px;" >&nbsp;</div>
            <div style="width: 40px; float: left; background-color: red; margin-left: 1px;" >&nbsp;</div>
            <div style="width: 40px; float: left; background-color: red; margin-left: 1px;" >&nbsp;</div>
            <div style="width: 40px; float: left; background-color: red; margin-left: 1px;" >&nbsp;</div>
            <div style="width: 40px; float: left; background-color: red; margin-left: 1px;" >&nbsp;</div>
            <div style="width: 40px; float: left; background-color: red; margin-left: 1px;" >&nbsp;</div>
        </td>
    </tr>
</table>
-->