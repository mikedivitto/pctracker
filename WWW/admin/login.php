<?php session_start(); if(isset($_SESSION[ 'status']) && $_SESSION[ 'status']===1 ) { header( "Location: ./index.php"); } ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">
    <title>Login</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/signin.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div class="container">
        <?php if(isset($_SESSION[ 'message'])) { echo '<div class="alert alert-danger">' . $_SESSION[ 'message'] . '</div>';} unset($_SESSION[ 'message']); ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <center>Login</center>
            </div>
            <div class="panel-body">
                <form class="form-signin" role="form" method=post action="./login_submit.php">
                    <h2 class="form-signin-heading">Please sign in</h2>
                    <h6></h6>
                    <input name="id" type="test" class="form-control" placeholder="Username" required autofocus>
                    <h6></h6>
                    <input name="password" type="password" class="form-control" placeholder="Password" required>
                    <div class="row">
                        <div class="col-md-6">
                            <button class="btn btn-danger btn-block" type="reset" onclick="window.location.href='../'">Cancel</button>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-primary btn-block" type="submit">Sign in</button>
                        </div>
                    </div>
            </div>
            </form>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>

</html>