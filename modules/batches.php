<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>JECRC</title>
<?php
	require_once('css.php');
?>
<link rel="icon" type="image/png" href="#" >
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!--Adjusting for Mobile View-->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

</head>

<body>


<div class="container-fluid">
	<div class="row ">
   		 <div class="col-sm-2 col-md-2 sidebar">
          	<ul class="nav nav-sidebar">
            	<li class="active"><a href="#">Faculty Panel</a></li>
            	<li><a href="#">Reports</a></li>
            	
          	</ul>
          	<ul class="nav nav-sidebar">
            	<li><a href="">CS</a></li>
            	<li><a href="">ECE</a></li>
            	<li><a href="">MECH</a></li>
            	<li><a href="">IT</a></li>
            	<li><a href="">CIVIL</a></li>
          	</ul>
          	<ul class="nav nav-sidebar">
            	<li><a href="">Settings</a></li>
          	</ul>
        </div>
        <div class="col-sm-10 col-sm-offset-2 col-md-10 col-md-offset-2 ">
        	<!--Adding the navigation-->
			<div class="navbar navbar-default   jecrc-nav" role="navigation">
            	<div class="row">
        			<div class="navbar-header">
          				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            				<span class="sr-only">Toggle navigation</span>
            				<span class="icon-bar"></span>
            				<span class="icon-bar"></span>
            				<span class="icon-bar"></span>
          				</button>
          				<a class="navbar-brand" href="#">DAILY RECORD MANAGEMENT</a>
        			</div>
        			<div class="navbar-collapse collapse" >
          				<ul class="nav navbar-nav navbar-right">
            				<li class="jecrc-nav-hide"><a href="#">Dashboard</a></li>
            				<li class="jecrc-nav-hide"><a href="#">Settings</a></li>
            				<li class="jecrc-nav-hide"><a href="#">Profile</a></li>
          				</ul> 
          			</div>
            	</div><!--End of NAVBAR ROW DIV-->
     		</div><!--End of NAVBAR -->
            
            <!----Start of another row --->
            <div>
            
            	<!--DIV FOR DISPAYING STATISTICS-->
            	<div  class="col-md-8 statistics  col-xs-12 ">
                	<div class="col-md-12">
                    	<div class="col-md-12">
                    	<h4>CSE</h4>
                        <hr>
                        <div class="col-md-3">
                        <h4 class="yearname">I YEAR</h4>
                        <hr>
                        	<a class="alert h5 alert-success batch_display"  role="alert">1CSA</a>
                          <h5 class="alert alert-danger batch_display" role="alert">1CSB</h5>
                           <h5 class="alert alert-warning batch_display" role="alert">1CSC</h5>
                            <h5 class="alert alert-info batch_display" role="alert">1CSD</h5>
                        </div>
                        
                         <div class="col-md-3">
                         <h4 class="yearname">II YEAR</h4>
                         <hr>
                         	 <h5 class="alert alert-danger batch_display" role="alert">3CSA</h5>
                          <h5 class="alert alert-info batch_display" role="alert">3CSB</h5>
                           <h5 class="alert alert-success batch_display" role="alert">3CSC</h5>
                            <h5 class="alert alert-warning batch_display" role="alert">3CSD</h5>
                         </div>
                        
                         <div class="col-md-3">
                          <h4 class="yearname">III YEAR</h4><br>
                          <hr>
                         	 <h5 class="alert alert-success batch_display" role="alert">5CSA</h5>
                             <h5 class="alert alert-danger batch_display" role="alert">5CSB</h5>
                         </div>
                        
                         <div class="col-md-3">
                          <h4 class="yearname">IV YEAR</h4>
                          <hr>
                         	<h5 class="alert alert-warning batch_display" role="alert">7CSA</h5>
                            <h5 class="alert alert-info batch_display" role="alert">7CSB</h5>
                         </div>
                        
                           
                    </div>
                       
                    </div>
                </div>
            
                
                <!--DIV FOR CREATING DEPT AND OTHER FIELDS-->
                
		</div><!--END of col-sm-10 col-md-10 class DIV-->
	</div><!--End of Main row div-->
</div><!--End of container-fluid div-->

<script>
//$('.batch_display').css('cursor','pointer');
/* var batches = document.getElementsByClassName('batch_display');
 var margin_increment = 20;
 var margin =50;
 var c=0;
   for(var i=0;i<batches.length;i++)
   {
	   batches[i].style.marginLeft = margin+"px";
	   margin = margin +20;
	   if(margin > 120)
	   margin = 0;
	  
	   
   }
    	//batches[c+1].style.marginLeft='150px';
	  // batches[c+2].style.marginLeft='75px';
	  // batches[c+3].style.marginLeft='175px';*/
</script>




<!--script area-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="static/jquery/jquery-1.7.2.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script type="text/javascript" src="static/bootstrap/js/bootstrap.js"></script>
<!--<script src="http://documentcloud.github.com/underscore/underscore-min.js"></script>
<script src="http://documentcloud.github.com/backbone/backbone-min.js"></script>
<script src="static/js/Backbone.localStorage-master/backbone.localStorage-min.js"></script>-->
<script type="text/javascript" src="static/dependencies/underscore-min.js"></script>
<script type="text/javascript" src="static/dependencies/backbone-min.js"></script>
<script type="text/javascript" src="static/dependencies/backbone.localStorage-min.js"></script>
<!--Now loading MVC related files -->
<script type="text/javascript" src="static/js/models/jecrc-model.js"></script>
<script type="text/javascript" src="static/js/collections/jecrc-collection.js"></script>
<script type="text/javascript"  src="static/js/views/app-pages.js"></script>
<script type="text/javascript" src="static/js/views/jecrc-view.js"></script>
<script type="text/javascript" src="static/js/routers/jecrc-routers.js"></script>
<script type="text/javascript" src="static/js/app-main/jecrc-app-main.js"></script>    
<script type="text/javascript" src="static/customscript/myscript.js"></script>
</body>
</html>
