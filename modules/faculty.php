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
            	<div class="col-md-8 statistics  col-xs-12 ">
                	 <div class="col-md-12">
                    	<h4>Saturday</h4>
                    	<span >August 18</span>
                        <div class="col-md-12 jecrc-stats">
                        	<div class="table-responsive">
  								<table class="table table-striped">
                                	<thead>
    									<tr>
                                    		<th>I</th>
                                        	<th>II</th>
                                        	<th>III</th>
                                        	<th>IV</th>
                                        	<th>V</th>
                                        	<th>VI</th>
                                    	</tr>
                                   	</thead>
                                    <tbody>
                                    	<tr>
                                        	<td>D.E</td>
                                            <td>ECE</td>
                                            <td>COMPILER</td>
                                            <td>JAVA</td>
                                            <td>EDC</td>
                                            <td>TOC</td> 
                                        </tr>
                                        <tr>
                                        	<td>80</td>
                                            <td>30</td>
                                            <td>20</td>
                                            <td>90</td>
                                            <td>10</td>
                                            <td>5</td> 
                                        </tr>
                                        <tr>
                                        	<td>P.K</td>
                                            <td>M.K</td>
                                            <td>S.K.</td>
                                            <td>U.D</td>
                                            <td>M.D</td>
                                            <td>X.D</td> 
                                        </tr>
                                    </tbody>
  								</table>
							</div><!--DIV ENDS FOR TABLE RESPONSIVE-->
                        </div>
                    </div>
                	<div class="col-md-12">
                    	<h4 id="faculty_attendance_heading4">CSE</h4>
                    	<span > 1CSA</span>
                        <div class="col-md-12 jecrc-stats">
                        	<div>
  								<input type="text" class="form-control jecrc-dept-entry" placeholder="Subject Name">
                                 <div class="col-sm-12">
                        <div class="btn-group active classlab" data-toggle="buttons">
  							<label class="btn btn-default ">
    							<input type="radio" name="options" id="option1" checked> Class
  							</label>
  							<label class="btn btn-default">
    							<input type="radio" name="options" id="option2"> Lab
  							</label>
						</div>
                    </div><!--DIV END FOR END SEMESTER-->
                                <div class="col-sm-12">
                        <div class="btn-group active classlab" data-toggle="buttons">
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
						</div>
                    </div><!--DIV END FOR END SEMESTER-->
                    <input type="text" class="form-control jecrc-dept-entry"  placeholder="Strength">
                    <input type="button" value="Save" class="btn btn-success faculty_button"></input>
                    <input type="button" value="Cancel" class="btn btn-danger faculty_button"></input>
                    <hr>
							</div><!--DIV ENDS FOR TABLE RESPONSIVE-->
                        </div><!--DIV ENDS FOR JECRC STATS-->
                    </div>
                </div>
            
                
                <!--DIV FOR CREATING DEPT AND OTHER FIELDS-->
                
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
