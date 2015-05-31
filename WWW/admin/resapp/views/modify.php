<?php $id = escape($_REQUEST['id']); ?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <center>Modify</center>
            </div>
            <div class="panel-body">
                <table id="records_table"></table>
                <form action="res.php" class="form-horizontal">
                    <input type=hidden name=action value=modify />
                    <input type="hidden" class="form-control" id="modify_id" value="<?=$id?>" name="id" required>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="modify_name" placeholder="Name" name="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Student ID</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="modify_stid" placeholder="Student ID" name="stid">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="modify_emal" placeholder="Email" name="emal">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Phone</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="modify_phon" placeholder="Phone" name="phon">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-md-2 col-md-offset-1 control-label">Room</label>
                        <div class="col-md-3">
                            <select class="form-control" id="modify_room" placeholder="Room" name="room" required>
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
                            <input type="text" class="form-control" id="modify_starttm" placeholder="Start" name="starttm" required>
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-md-2 col-md-offset-1 control-label">Date</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control datepicker" id="modify_date" placeholder="Date" name="date" required readonly="readonly" style="background-color:#FFFFFF">
                        </div>
                        <label for="inputEmail3" class="col-md-2 control-label">End</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="modify_endtm" placeholder="End" name="endtm" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-7 col-sm-10">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-default" onclick="window.location.href='./'">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $.ajax({
        url: 'http://cs.newpaltz.edu/~divittom/resapp/res.php?action=get&format=json&id=<?=$id?>',
        type: 'POST',
        dataType: "json",
        success: function (response) {
            //console.log(response);
            //var trHTML = '';
            $.each(response, function (i, item) {
                $('#modify_name').val(item.NAME);
                $('#modify_stid').val(item.STID);
                $('#modify_emal').val(item.EMAL);
                $('#modify_phon').val(item.PHON);
                $('#modify_room').val(item.ROOM);
                $('#modify_date').val(item.DATE);
                $('#modify_starttm').val(item.STARTTM);
                $('#modify_endtm').val(item.ENDTM);
            });
        }
    });
</script>
<script>
    $("#modify_date").datepicker({
        dateFormat: "yy-mm-dd"
    });
    $("#modify_starttm").timepicker({
        'scrollDefault': 'now',
        'minTime': '9:00am',
        'maxTime': '9:00pm'
    });
    $("#modify_endtm").timepicker({
        'scrollDefault': 'now',
        'minTime': '9:00am',
        'maxTime': '9:00pm'
    });
</script>