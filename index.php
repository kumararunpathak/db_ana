<?php      
	 if(empty($_SESSION)) 
	   session_start();
	  if(!isset($_SESSION['username'])) { //if not yet logged in
	     header("Location: login.php");// send to login page
	     exit;
	   } 
	   CONST IMAGE_LOCATION = 'Archive/Archive';
	   $placement_id =  $_GET['placement_id'];
	   $placement_id = $placement_id == ""?3669452:$placement_id;
	   $files = Array();
	   if(is_dir(IMAGE_LOCATION . "/" .$placement_id))
          $files = scandir(IMAGE_LOCATION . "/" .$placement_id);

	   
	   $placementName = $placement_id;
	   //$pName = substr($placement_id, strlen($pId) + 1);
	   #$placementName = str_replace("_"," ",$placementName);
	   #$placementName = str_replace("-"," ",$placementName);
	  // $placementName
	   
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
                        <a class="logo logo-navigation" href="placements.php"></a>
                    </li>
                </ul>
                 <h4><a class="logoout pull-right" href="logout.php">Logout</a></h4>
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
                <h1 class="page-header">Campaign Optimization Dashboard
                   <small></small> 
                </h1>
                <small class=""> <a href="placements.php">Back</a> >> <?php echo $placementName;?> </small>
            </div>
        </div>
        <!-- /.row -->

        <!-- Projects Row -->
       
       <?php foreach ($files as $key => $val ):?>
          <?php if(!(substr($val, 0, 1) == '.')): ?>
            <div class="col-md-6 portfolio-item">
                <a href="#">
                    <img class="img-responsive" src=<?php echo   "Archive/Archive/" .$placement_id . "/". $val ; ?> alt="">
                </a>
                <h3>
                    <a href="#"><?php ?></a>
                </h3>
                <p></p>
            </div>
             <?php endif;?> 
           <?php endforeach;?>
        
        
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