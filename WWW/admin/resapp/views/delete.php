<?php $id=escape($_REQUEST[ 'id']); ?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <center>Delete</center>
            </div>
            <div class="panel-body">
                <form action="res.php" class="form-horizontal">
                    <input type=hidden name=action value=delete />
                    <input type="hidden" class="form-control" id="inputEmail3" placeholder="<?=$id?>" name="id" value="<?=$id?>" required readonly>
                    <p>Are you sure you want to delete?</p>
                    <div class="form-group">
                        <div class="col-sm-offset-8 col-sm-10">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-default" onclick="window.location.href='./'">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>