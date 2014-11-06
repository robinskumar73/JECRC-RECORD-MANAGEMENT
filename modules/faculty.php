<?php
require_once 'faculty_header.php';
include_once 'loadingbar.php';
?>


<div class="container-fluid">
	<div class="row ">
   		 <div class="col-sm-2 col-md-2 sidebar">
          	<ul class="nav nav-sidebar">
            	<li class="active"><a href="#">Faculty Panel</a></li>
            	<li><a href="#">Reports</a></li>
            	
          	</ul>
            <ul id="nav-dept-bar" class="nav nav-sidebar">
            	<!--<li><a href="">CS</a></li>-->
            	
          	</ul>
          	<ul class="nav nav-sidebar">
            	<!--Area for sidebar info-->
          	</ul>
            <!--
          	<ul class="nav nav-sidebar">
            	<li><a href="">Settings</a></li>
          	</ul>-->
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
                        <a id="Login" class="navbar-text navbar-right jecrc-nav-dept" href="loginscript/include/processes.php?log_out=true">Logout</a>
                        <a href="#" class="navbar-text navbar-right jecrc-nav-dept  " style="margin-right:20px"  onclick="window.print(); return false;"><span class="glyphicon glyphicon-print" style="color:#428bca"></span></a>
          			</div>
            	</div><!--End of NAVBAR ROW DIV-->
     		</div><!--End of NAVBAR -->
            
       <!----Start of another row --->
      <div>
      
        
      <!--DIV FOR DISPAYING STATISTICS-->      	
      <div id="jecrc-main-screen"  class="col-md-8 statistics  col-xs-12 ">
     
           <div id="faculty-display-screen">
           		
           </div>
           
           <div id="faculty-entry-record">
           		<!--Faculty entry form to be pasted here-->
           </div> 
           
	  </div><!--DIV ENDS FOR DISPAYING STATISTICS-->

                
                
		</div><!--END of col-sm-10 col-md-10 class DIV-->
	</div><!--End of Main row div-->
</div><!--End of container-fluid div-->


<?php
include_once 'faculty_footer.php';
?>
