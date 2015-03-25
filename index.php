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
	   
	   $data = file_get_contents('data.json');
	   
	   $data = json_decode($data);

	   $pubName = substr($placement_id, 11);
	   
	   $advList = $data->$pubName;
	   
	   $queryParams = explode('?', $_SERVER[REQUEST_URI]);
	   $baseUrl = $_SERVER['HTTP_HOST'].$queryParams[0]."?placement_id=".$placement_id;
	   
	   $adv_ids = $_GET['adv_ids'];
	   $adv_ids = explode(",",$adv_ids);
	   
	   $filter = $_GET['filter'];
	   
	   
	   if(count($adv_ids) == 0 || (count($adv_ids) == 1 && $adv_ids[0] == "")){
	   		$passPattern = array(
	   			'pie_impression',
	   			'pie_Total',
	   			'pub_id',
	   			'pub_rpm_id',
	   			'line_Fill',
	   			'pie_RPM'
	   		);
	   }else{
	   		$passPattern = array();
	   }
	 
	   if($filter == 'compare'){
           $pass1 = 'Two_bar_advetrtiser_id_'. $adv_ids[0]."_".$pubName."_".$adv_ids[1];
           $pass2 = 'Two_bar_advetrtiser_id_'. $adv_ids[1]."_".$pubName."_".$adv_ids[0];
           $passPattern[] = $pass1;
           $passPattern[] = $pass2;
	   }
	   
	   if($filter == 'filter'){
	      foreach ($adv_ids as $val){
	      	if($val){
	      		$pass1 = 'line_advertiser_id_'.$val;
	      		$passPattern[] = $pass1;
	      	}
	      }
	   }
	 
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
                   <small><button class="pull-right" id="filter" class="btn btn-primary">Show Filter</button> </small>
                </h1>
                
        <div id="filter_div" style="display: none;">
           <h4>Select checkbox to filter the contents</h4>
           <hr>
			  <?php if($advList):?>
			  <?php foreach ($advList as $key => $val):?>
			  <div class="checkbox">
			    <label>
			      <input type="checkbox" value="<?php echo $val[0]; ?>"> <?php echo $val[0] .", This week revenue $".$val[1] ?>
			    </label>
			  </div>
			  <?php endforeach;?>
			  <?php endif;?>
			  <br />
			  <button  class="btn btn-primary" id="filter-but">Filter</button>
			  <button class="btn btn-primary" id="comp-but">Compare</button>
			
        </div> 
                
                <small class=""> <a href="placements.php">Back</a> >> <?php echo $pubName;?> </small>
            </div>
        </div>
        
        <!-- /.row -->

        <!-- Projects Row -->
       
       <?php foreach ($files as $key => $val ):?>
       
          <?php if(!$filter):?>
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
	          
          <?php else:?>          
	          <?php 
	          foreach ($passPattern as $pattern):
	             if (strpos($val,$pattern) !== false) { ?>
	             	<div class="col-md-6 portfolio-item">
	             		<a href="#"><img class="img-responsive" src=<?php echo   "Archive/Archive/" .$placement_id . "/". $val ; ?> alt=""></a>
	                	<h3> <a href="#"><?php ?></a></h3><p></p>
	             	</div>
                 <?php  }
	           
	           endforeach;
	           ?>          
          <?php endif;?>
          
       
       <?php endforeach;?>
        
        <input type="text" value="<?php echo $baseUrl?>" id="base_url"/>
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
    
    <script type="text/javascript">

    var filterList = [];
    var compareList = [];
    
    $("#filter").click(function(){
        $("#filter_div").toggle();
        if($(this).text() == "Show Filter"){
        	$(this).text('Hide Filter')
        }else{
        	$(this).text('Show Filter')
        }
    });

    $("input[type=checkbox]" ).on( "click", function(e){
          var val = $(this).val();
          if($(this).is(":checked")){
        	  filterList.push(val);
        	  compareList.push(val);
          }else{
        	  filterList.splice($.inArray(val, filterList),1);
        	  compareList.splice($.inArray(val, compareList),1);
          }
    });
    
    $("#filter-but").on("click",function(){
    	//if(compareList.length == 0){
    		//alert("Please select at least one 1 element to filter");
    	//}else{
        	var queryString = '';
        	for(var i= 0 ; i< filterList.length ; i++){
        		queryString = (queryString == "") ?filterList[i] : queryString + "," + filterList[i];
        	}
        	var url = "http://"+ $('#base_url').val() +"&adv_ids="+queryString +"&filter=filter";
        	window.location.href = url;
    	//}
    });
    
    $("#comp-but").on("click",function(){
    	if(compareList.length == 2){
        	var queryString = '';
        	for(var i= 0 ; i< compareList.length ; i++){
        		queryString = (queryString == "") ?compareList[i] : queryString + "," + compareList[i];
        	}
           var url = "http://"+ $('#base_url').val() +"&adv_ids="+queryString +"&filter=compare";
           window.location.href = url;
    	}else{
        	alert("Please select 2 elements for compare");
    	}
    });
    
    </script>
    
</body>
</html>