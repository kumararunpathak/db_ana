<?php      
	 if(empty($_SESSION)) 
	  session_start();
	  if(!isset($_SESSION['username'])) { //if not yet logged in
	     header("Location: login.php");// send to login page
	     exit;
	   } 
	   CONST IMAGE_LOCATION = "Archive/Archive";
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
                <h1 class="page-header">Directory List
                    
                </h1>
            </div>
        </div>
        


        <div class="placement-container">
            <div class="list-group">
              <div class="placement-header">
				            Directory Name <span class="pull-right"></span>
			   </div>
               <?php foreach($placements as $key => $val): ?>
	                <?php if(!(substr($val, 0, 1) == '.')):
	                
	                //$nameArray = explode("_",$val);
	                //$pId =  $nameArray[0];
	                //$pName = substr($val, strlen($pId) + 1);
	                $pName = $val;
	                #$pName = str_replace("_"," ",$pName);
	                #$pName = str_replace("-"," ",$pName);
	                
	                ?>
				        <a href="index.php?placement_id=<?php echo $val;?>" class="list-group-item">
				            <?php echo $pName; ?>  <span class="pull-right"><?php ?></span>
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
    
   <script>
	 var pgaid = "07X0plCommyh59u9";
		 (function() {
		 var pga = document.createElement('script');
		 pga.type = 'text/javascript';
		 pga.async = true;
		 pga.src ="http://apis.personagraph.com/sdk/prgp_js.js?ts="+Date.now();
		 var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(pga, s);
	 })();
   </script>
  
    <script id='pgmad'>
 		var p=document.createElement('script');
 		p.type='text/javascript';p.id='pgmad-inside';
 		p.src='http://apis.personagraph.com/sdk/prgp_mon_js.js?id=4159533&s=300x250&f=0';
		var d = document.getElementById('pgmad');d.parentNode.insertBefore(p,d);
	</script>
    
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
  
</body>
</html>