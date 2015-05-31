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
                            <input type="text" class="form-control datepicker" id="datepicker" placeholder="Date" name="date" required readonly="readonly" style="background-color:#FFFFFF">
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
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <button style="float: left; margin-top: -2px;" class="btn btn-success btn-xs" data-toggle="modal" data-target="#addComp"><span class="glyphicon glyphicon-plus"></span> Add</button>
                <center style="margin-right: 60px;">Current Data</center>
            </div>
            <div class="panel-body">
                <table id="records_table" class="table table-striped">
                    <th>Name</th>
                    <th>Student ID</th>
                    <th>Phone</th>
                    <th>Room</th>
                    <th>Date</th>
                    <th>Start</th>
                    <th>End</th>
                    <th>Status</th>
                    <th>Options</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $.ajax({
        url: 'http://cs.newpaltz.edu/~divittom/resapp/res.php?action=getAll&format=json',
        type: 'POST',
        dataType: "json",
        success: function (response) {
            var trHTML = '';
            $.each(response, function (i, item) {
                trHTML += '<tr><td>' + item.NAME + '</td><td>' + item.STID + '</td><td>' + item.PHON + '</td><td>' + item.ROOM + '</td><td>' + item.DATE + '</td><td>' + item.STARTTM + '</td><td>' + item.ENDTM + '</td><td>' + item.STATUS + '</td><td><a href="res.php?action=status&status=approved&id=' + item.id + '" title="Approve"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></a>&nbsp;<a href="res.php?action=status&status=denied&id=' + item.id + '" title="Deny"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>&nbsp;<a href="?action=modifyView&id=' + item.id + '" title="Modify"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>&nbsp;<a href="mailto:' + item.EMAL + '" title="Send Email"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></a>&nbsp;<a href="?action=deleteView&id=' + item.id + '" title="Delete"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td></tr>';
            });
            $('#records_table').append(trHTML);
        }
    });
    $('.modal').on('shown.bs.modal', function () {
        $(this).find('[autofocus]').focus();
    });
</script>
<script>
    $("#datepicker").datepicker({
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