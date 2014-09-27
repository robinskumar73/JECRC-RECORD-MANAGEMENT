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
   <!--Modal-->
   <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Faculty Settings</h4>
      </div>
      <div class="modal-body">
        <!--Tab Control -->
       	 <ul class="nav nav-tabs" role="tablist">
  			<li class="active"><a href="#cse" role="tab" data-toggle="tab">CSE</a></li>
  			<li><a href="#mech" role="tab" data-toggle="tab">MECH</a></li>
  			<li><a href="#ece" role="tab" data-toggle="tab">ECE</a></li>
  			<li><a href="#eee" role="tab" data-toggle="tab">EEE</a></li>
            <li><a href="#it" role="tab" data-toggle="tab">IT</a></li>
            <li><a href="#civil" role="tab" data-toggle="tab">CIVIL</a></li>
		</ul>

		<!-- Tab panes -->
		<div class="tab-content">
 			 <div class="tab-pane active" id="cse">
             	<h4 class="modal_h4">Faculty</h4>
                <span class="modal_span">Pankaj Tiwari</span><br />
                <span class="modal_span">Mukt Bihari</span><br />
                <span class="modal_span">Mukesh Agarwal</span><br />
                <span class="modal_span">Udbhav Bhatnagar</span><br />
                <span class="modal_span">Sharman Joshi</span><br />
                <span class="modal_span">Anandya Gupta</span><br />
                <span class="modal_span">Azaz Khan</span>
             </div>
 			 <div class="tab-pane" id="mech">
             	<h4 class="modal_h4">Faculty</h4>
                <span class="modal_span">Ramartan Sharma</span><br />
                <span class="modal_span">Muniketan Das</span><br />
                <span class="modal_span">Amir Khan</span><br />
                <span class="modal_span">Sharukh Khan</span><br />
                <span class="modal_span">Sharman Joshi</span><br />
                <span class="modal_span">Hritik Roshan</span><br />
                <span class="modal_span">Akshay Kumar</span>
             </div>
 			 <div class="tab-pane" id="ece">
             	<h4 class="modal_h4">Faculty</h4>
                <span class="modal_span">Pankaj Tiwari</span><br />
                <span class="modal_span">Mukt Bihari</span><br />
                <span class="modal_span">Mukesh Agarwal</span><br />
                <span class="modal_span">Udbhav Bhatnagar</span><br />
                <span class="modal_span">Sharman Joshi</span><br />
                <span class="modal_span">Anandya Gupta</span><br />
                <span class="modal_span">Azaz Khan</span>
             </div>
 			 <div class="tab-pane" id="eee">
             <h4 class="modal_h4">Faculty</h4>
                <span class="modal_span">Ramartan Sharma</span><br />
                <span class="modal_span">Muniketan Das</span><br />
                <span class="modal_span">Amir Khan</span><br />
                <span class="modal_span">Sharukh Khan</span><br />
                <span class="modal_span">Sharman Joshi</span><br />
                <span class="modal_span">Hritik Roshan</span><br />
                <span class="modal_span">Akshay Kumar</span>
             </div>
             <div class="tab-pane" id="it">
             <h4 class="modal_h4">Faculty</h4>
                <span class="modal_span">Pankaj Tiwari</span><br />
                <span class="modal_span">Mukt Bihari</span><br />
                <span class="modal_span">Mukesh Agarwal</span><br />
                <span class="modal_span">Udbhav Bhatnagar</span><br />
                <span class="modal_span">Sharman Joshi</span><br />
                <span class="modal_span">Anandya Gupta</span><br />
                <span class="modal_span">Azaz Khan</span>
             </div>
             <div class="tab-pane" id="civil">
            <h4 class="modal_h4">Faculty</h4>
                <span class="modal_span">Ramartan Sharma   -</span><br />
                <span class="modal_span">Muniketan Das   -</span><br />
                <span class="modal_span">Amir Khan   -</span><br />
                <span class="modal_span">Sharukh Khan</span><br />
                <span class="modal_span">Sharman Joshi</span><br />
                <span class="modal_span">Hritik Roshan</span><br />
                <span class="modal_span">Akshay Kumar</span>
             </div>
		</div>
        <!--Tab Control End -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
   <!--Modal End -->

<div class="container-fluid">
	<div class="row ">
   		 <div class="col-sm-2 col-md-2 sidebar">
          	<ul class="nav nav-sidebar">
            	<li class="active"><a href="#">Admin Panel</a></li>
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
          				<a class="navbar-brand" href="#">SETTINGS</a>
        			</div>
        			<div class="navbar-collapse collapse" >
          				<ul class="nav navbar-nav navbar-right">
            				<li class="jecrc-nav-hide"><a href="#">Dashboard</a></li>
            				<li class="jecrc-nav-hide"><a href="#">Settings</a></li>
            				<li class="jecrc-nav-hide"><a href="#">Profile</a></li>
                            <li class="jecrc-nav-hide"><a href="#">Branch</a></li>
          				</ul> 
          				<span class="navbar-text navbar-right jecrc-nav-dept"> Create Department </span>
        			</div>
            	</div><!--End of NAVBAR ROW DIV-->
     		</div><!--End of NAVBAR -->
            
            <!----Start of another row --->
            <div>
            
            	<!--DIV FOR DISPAYING STATISTICS-->
            	<div class="col-md-8 statistics  ">
                	<div class="col-md-12">
                     <h4 class="settings_h4">Department</h4>
                     <span>Remove</span><br />
                     <canvas class="canvastree" width="125" height="100"></canvas>
                     <h4  class="settings_h4">Faculty</h4>
                     <span>Remove</span><br />
                     <canvas class="canvastree" width="225" height="100"></canvas>
                    	<!--<button class="btn btn-default btn-lg" data-toggle="modal" data-target="#myModal" style="margin-left:40px"						                        >-</button><br/>-->
                        <h4 class="settings_h4">Semester</h4>
                        <span>Remove</span><br />
                        <canvas class="canvastree" width="325" height="100"></canvas>
                        <h4 class="settings_h4">Batch</h4>
                        <span>Remove</span><br />
                        <canvas class="canvastree" width="425" height="100"></canvas>
                        <h4 class="settings_h4">Data</h4>
                        <span>Reset</span><br />
                       
                         
                        <script>
						var canvas = document.getElementsByClassName('canvastree');
						var x1 = 100;
						var x2 = 100;
						var y1 = 10;
						var y2 = 90;
						for( var i=0;i<canvas.length;i++)
						{
						
						var context = canvas[i].getContext('2d');
						context.beginPath();
						context.arc(x1,5,5,0,2*Math.PI);
						context.moveTo(x1,y1);
						context.lineTo(x2,y2);
						context.arc(x1,95,5,0,2*Math.PI);
						context.strokeStyle="#5cb85c";
						context.stroke();
						x1 = x1 + 100;
						x2 = x2 + 100;
						}
						var modal = document.getElementClassName('settings_h4');
						modal.onclick = function() {
							$('#myModal').modal('show');
						}
						</script>
                         
                        <div class="col-md-12 jecrc-stats">
                        	<div class="table-responsive">
  								
							</div><!--DIV ENDS FOR TABLE RESPONSIVE-->
                        </div><!--DIV ENDS FOR JECRC STATS-->
                    </div>
                </div>
            
                
                <!--DIV FOR CREATING DEPT AND OTHER FIELDS-->
                <div class="col-sm-4">
                	<div id="DepartmentCreate" class="col-sm-12 ">
                		<input type="text" class="form-control jecrc-dept-entry" placeholder="Department Name">
                    	<button type="button" class="btn btn-default" style="float:right">Create</button>
                    </div>
                    <div id="AddSemester" class="col-sm-12 AddSemester">
                    	<h4 class="blue-text semAddHeading">Add Semester</h4>
                        <div class="btn-group" data-toggle="buttons">
  							<label class="btn btn-info active">
    							<input type="radio" name="options" id="option1" checked> I
  							</label>
  							<label class="btn btn-info">
    							<input type="radio" name="options" id="option2"> II
  							</label>
  							<label class="btn btn-info">
    							<input type="radio" name="options" id="option3"> III
  							</label>
                            <label class="btn btn-info">
    							<input type="radio" name="options" id="option3"> IV
  							</label>
                            <label class="btn btn-info">
    							<input type="radio" name="options" id="option3"> V
  							</label>
                            <label class="btn btn-info">
    							<input type="radio" name="options" id="option3"> VI
  							</label>
                             <label class="btn btn-info">
    							<input type="radio" name="options" id="option3"> VII
  							</label>
                             <label class="btn btn-info">
    							<input type="radio" name="options" id="option3"> VIII
  							</label>
						</div>
                    </div><!--DIV END FOR END SEMESTER-->
                    
                    <div id="AddBatches" class="col-sm-12 AddBatches">
                    	<h4 class="blue-text semAddHeading" >Add Batches</h4>
                        <div class="btn-group" data-toggle="buttons">
  							<label class="btn btn-info active">
    							<input type="checkbox" checked> A
  							</label>
  							<label class="btn btn-info">
    							<input type="checkbox"> B
  							</label>
  							<label class="btn btn-info">
    							<input type="checkbox"> C
  							</label>
                            <label class="btn btn-info">
    							<input type="checkbox"> D
  							</label>
                            <label class="btn btn-info">
    							<input type="checkbox"> E
  							</label>
                            <label class="btn btn-info">
    							<input type="checkbox"> F
  							</label>
                             <label class="btn btn-info">
    							<input type="checkbox"> G
  							</label>
                            <label class="btn btn-info">
    							<input type="checkbox"> H
  							</label>
                            <label class="btn btn-info">
    							<input type="checkbox"> I
  							</label>
						</div>
                       
                    </div><!--DIV END FOR END ADD BATCHES-->
                    <div class="col-sm-12">
                      <button type="button" class="btn btn-default" style="float:right;margin-top:25px;">Publish</button>
                    </div>
                    
                    <!--DIV FOR DISPLAYING THE SELECTED SEMESTERS-->
                    <div class="col-sm-12" style="margin-top:20px">
                    	<div class="InfoScreen">
                    		<h2 class="infoScreenHeader">3CS</h2>
                        	<p class="infoScreenSubHeader">
                        		<span class="h4">3CSA</span>
                        		<span class="h4">3CSB</span>
                        		<span class="h4">3CSC</span>
                        		<span class="h4">3CSD</span>
                        		<span class="h4">3CSE</span>
                        		<span class="h4">3CSF</span>
                        		<span class="h4">3CSG</span>
                        		<span class="h4">3CSH</span>
                        		<span class="h4">3CSI</span>
                        	</p>
                    	</div><!--DIV ENDS FOR INFO SCREEN-->
                	</div> <!--DIV ENDS FOR DISPLAYING THE SELECTED SEMESTERS-->
                    
                    <!--DIV FOR ADDING FACULTY-->
                    <div id="AddFaculty" class="col-md-12 AddFaculty" >
                    	<h4 class="blue-text semAddHeading" style="margin-bottom:18px;" > + Add Faculty</h4>
                        <input type="text" class="form-control faculty-dept-entry "  placeholder="First Name">
                        <input type="text" class="form-control faculty-dept-entry" placeholder="Last Name">
                        <input type="text" class="form-control faculty-dept-entry" placeholder="User Name">
                    	<button type="button" class="btn btn-default" style="float:right">Create</button>
                    </div><!--DIV ENDS FOR ADDING FACULTY-->
                    
            	</div><!--<!--DIV ENDS FOR CREATING DEPT AND OTHER FIELDS-->
         	</div><!--DIV ENDS FOR ANOTHER ROW-->
		</div><!--END of col-sm-10 col-md-10 class DIV-->
	</div><!--End of Main row div-->
</div><!--End of container-fluid div-->






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
