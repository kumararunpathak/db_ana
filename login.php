<?php
if(empty($_SESSION))
   session_start();

if(isset($_SESSION['username'])) { 
   header("location: placements.php");
   exit; 
}

$wrongCredential = false;

if(!empty($_POST)) { 
	if($_POST['username'] == "admin" && $_POST['password'] == "admin"){
		$_SESSION['username'] = "admin";
		header("location: placements.php");
		exit;
	}else{
		$wrongCredential = true;
	}
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Analytics Dashboard - Login</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/layout.css" rel="stylesheet">
</head>
<body>
<div class="bs-example">
    <form action="login.php" class="form-horizontal" method="post">
        <div class="logo"></div>
        
        <?php if($wrongCredential == true): ?>
          <div class="alert alert-danger alert-error">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            Wrong Credentials.
         </div>
        <?php endif;?>
        
        <div class="form-group">
            <label for="inputEmail" class="control-label col-xs-2">Username</label>
            <div class="col-xs-10">
                <input type="text" class="form-control" id="inputEmail" name="username">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword" class="control-label col-xs-2">Password</label>
            <div class="col-xs-10">
                <input type="password" class="form-control" id="inputPassword" name="password">
            </div>
        </div>
        <div class="form-group">
            <div class="col-xs-offset-2 col-xs-10">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </div>
    </form>
</div>

  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>

</body>
</html>      