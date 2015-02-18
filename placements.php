<?php      
	 if(empty($_SESSION)) 
	  session_start();
	  if(!isset($_SESSION['username'])) { //if not yet logged in
	     header("Location: login.php");// send to login page
	     exit;
	   } 
	   CONST IMAGE_LOCATION = "Archive";
	   $placements = scandir(IMAGE_LOCATION);
  ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Placement - Analytics</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/layout.css" rel="stylesheet">
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a class="logo logo-navigation" href="#"></a>
                    </li>
                </ul>
                 <h4><a class="logoout pull-right" href="/logout.php">Logout</a></h4>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <!-- Page Header -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Placement List
                    
                </h1>
            </div>
        </div>
        


        <div class="placement-container">
            <div class="list-group">
               <?php foreach($placements as $key => $val): ?>
	                <?php if(is_numeric($val)):?>
				        <a href="index.php?placement_id=<?php echo $val;?>" class="list-group-item">
				             <?php echo $val; ?> <span class="badge"></span>
				        </a>
			        <?php endif; ?>
               <?php endforeach; ?>
            </div>
        </div>
        
        <hr>
        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p></p>
                </div>
            </div>
            <!-- /.row -->
        </footer>

    </div>
    <!-- /.container -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
  
</body>
</html>