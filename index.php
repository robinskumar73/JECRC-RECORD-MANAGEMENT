<?php

include_once 'modules/loginscript/include/processes.php';
$Login_Process = new Login_Process;
if($Login_Process->check_status($_SERVER['SCRIPT_NAME']))
{

?>

<?php
require_once 'modules/header.php';
?>

<?php
//Show this only if user is admin..
 if ($_SESSION['admin'] == 1){
	
?>

<?php
include_once 'modules/loadingbar.php';

?>

<div class="container-fluid">

	<div class="row ">
    
   		 <div class="col-sm-2 col-md-2 sidebar">
          	<ul class="nav nav-sidebar">
            	<li class="active"><a href="#">Admin Panel</a></li>
            	<li><a href="#">Reports</a></li>
            	
          	</ul>
          	<ul id="nav-dept-bar" class="nav nav-sidebar">
            	<!--<li><a href="">CS</a></li>-->
            	
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
          				<a class="navbar-brand" href="#">JECRC RECORD MANAGEMENT</a>
        			</div>
        			<div class="navbar-collapse collapse" >
          				<ul id="collapse-nav-bar" class="nav navbar-nav navbar-right">
                        	<h3 class="navbar-text jecrc-nav-hide ">Departments</h3>
            		<!--		<li class="jecrc-nav-hide"><a href="#">Settings</a></li>-->
          				</ul> 
                       
                        <a id="Login" class="navbar-text navbar-right jecrc-nav-dept" href="modules/loginscript/include/processes.php?log_out=true">Logout</a>
                        
                         <a href="#" class="navbar-text h4 navbar-right jecrc-nav-dept " style="margin-right:40px"  onclick="window.print(); return false;"><span class="glyphicon glyphicon-print"><span style="padding-left:6px">Print</span></span></a>
          				<!--<a class="navbar-text navbar-right jecrc-nav-dept" href="#">+ Create Department </a>-->
        			</div>
            	</div><!--End of NAVBAR ROW DIV-->
     		</div><!--End of NAVBAR -->
            
            <!----Start of another row --->
            <div>
            
            	<!--DIV FOR DISPAYING STATISTICS-->
            	<div id="jecrc-main-screen" class="col-md-8 statistics  ">
                	<div class="col-md-12">
                    	<h4>Wednesday</h4>
                    	<span >August 20</span>
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
                                            <td colspan="3" rowspan="0">ECE  B1-Batch 10  P.K</td>
                                            <td>COMPILER</td>
                                            <td>JAVA</td>
                                            <td>EDC</td>
                                            <td>TOC</td> 
                                        </tr>
                                        <tr>
                                        	<td>80</td>
                                            <td colspan="3" rowspan="1">ECE  B2-Batch   20  R.K</td>
                                            <td>20</td>
                                            <td>90</td>
                                            <td>10</td>
                                            <td>5</td> 
                                        </tr>
                                        <tr>
                                        	<td>P.K</td>
                                            <td colspan="3" rowspan="3">ECE  B2-Batch 20  A.K</td>
                                            <td>S.K.</td>
                                            <td>U.D</td>
                                            <td>M.D</td>
                                            <td>X.D</td> 
                                        </tr>
                                    </tbody>
  								</table>
							</div><!--DIV ENDS FOR TABLE RESPONSIVE-->
                        </div><!--DIV ENDS FOR JECRC STATS-->
                    </div>
                    <div class="col-md-12">
                    	<h4>Tuesday</h4>
                    	<span >August 19</span>
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
                    	<h4>Friday</h4>
                    	<span >August 17</span>
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
                </div>
            
                
                <!--DIV FOR CREATING DEPT AND OTHER FIELDS-->
                <div   class="col-sm-4">
                	<!--For displaying info and results-->
                	<p id="dept-info-box" class="text-danger col-sm-12 hide" style="text-align:center"></p>
                   <div id="DepartmentCreate" class="col-sm-12 ">
                   		<button id="Dept-Cancel" type="button" class="close hide"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                   		<h3 id="dept-screen" class="col-sm-12 infoScreenHeader hide" style="margin-top:2px;"></h3>
						<input type="text" id="Department" class="form-control typeahead jecrc-dept-entry" placeholder="Department Name">
    					<button type="button" id="create-dept" class="btn btn-primary jecrc-create-btn">Create</button>
                        

				    </div>
                                        
                    <div id="AddSemester" class="col-sm-12 AddSemester hide">
                    	<h4 class="blue-text semAddHeading">Add Semester</h4>
                        <div id="radio-btn" class="btn-group" data-toggle="buttons">
  							<label class="btn btn-primary ">
    							<input class="radio" type="radio" name="options" id="1" value="1"> I
  							</label>
  							<label class="btn btn-primary">
    							<input class="radio" type="radio" name="options" value="2" > II
  							</label>
  							<label class="btn btn-primary">
    							<input class="radio" type="radio" name="options" value="3"> III
  							</label>
                            <label class="btn btn-primary">
    							<input class="radio" type="radio" name="options" value="4"> IV
  							</label>
                            <label class="btn btn-primary">
    							<input class="radio" type="radio" name="options" value="5"> V
  							</label>
                            <label class="btn btn-primary">
    							<input class="radio" type="radio" name="options" value="6"> VI
  							</label>
                             <label class="btn btn-primary">
    							<input class="radio" type="radio" name="options" value="7"> VII
  							</label>
                             <label class="btn btn-primary">
    							<input class="radio" type="radio" name="options" value="8"> VIII
  							</label>
						</div>
                    </div><!--DIV END FOR END SEMESTER-->
                    
                    
                    
                    <div id="AddSection" class="col-sm-12 AddSemester hide">
                    	<h4 class="blue-text semAddHeading">Add Section</h4>
                        <div id="section-btn" class="btn-group" data-toggle="buttons">
  							<label class="btn btn-primary ">
    							<input type="radio" name="options" id_="1" value="A" > A
  							</label>
  							<label class="btn btn-primary">
    							<input type="radio" name="options" value="B"  id_="2"> B
  							</label>
  							<label class="btn btn-primary">
    							<input type="radio" name="options" value="C" id_="3"> C
  							</label>
                            <label class="btn btn-primary">
    							<input type="radio" name="options" value="D" id_="4"> D
  							</label>
                            <label class="btn btn-primary">
    							<input type="radio" name="options" value="E" id_="5"> E
  							</label>
                            <label class="btn btn-primary">
    							<input type="radio" name="options" value="F" id_="6"> F
  							</label>
                             <label class="btn btn-primary">
    							<input type="radio" name="options" value="G" id_="7"> G
  							</label>
                             <label class="btn btn-primary">
    							<input type="radio" name="options" value="H" id_="8"> H
  							</label>
                             <label class="btn btn-primary">
    							<input type="radio" name="options" value="I" id_="9"> I
  							</label>
                            
						</div>
                    </div><!--DIV END FOR END SECTION-->
                    
                    
                    
                    
                    <div id="AddBatches" class="col-sm-12 AddBatches hide">
                    	<h4 class="blue-text semAddHeading" >Select Batches</h4>
                        <div class="btn-group" data-toggle="buttons">
  							<label class="btn btn-primary dept-check"  data-wat='1'>
    							1
  							</label>
  							<label class="btn btn-primary dept-check"  data-wat='2'>
    							 2
  							</label>
  							<label class="btn btn-primary dept-check" data-wat='3'>
    							3
  							</label>
                            <label class="btn btn-primary dept-check" data-wat='4'>
    							4
  							</label>
                            <label class="btn btn-primary dept-check" data-wat='5'>
    							5
  							</label>
                            <label class="btn btn-primary dept-check" data-wat='6'> 
    							6
  							</label>
                             <label class="btn btn-primary dept-check" data-wat='7'>
    							7
  							</label>
                            <label class="btn btn-primary dept-check" data-wat='8'>
    							8
  							</label>
                            <label class="btn btn-primary dept-check" data-wat='9'>
    							9
  							</label>
						</div>
                       
                    </div><!--DIV END FOR END ADD BATCHES-->
                    <div id="publish-batch" class="col-sm-12 hide">
                      <button type="button" class="btn btn-primary jecrc-create-btn  addSemBtn">Publish</button>
                    </div>
                    
                    <!--DIV FOR DISPLAYING THE SELECTED SEMESTERS-->
                    <div id="infoScreen" class="col-sm-12 hide" style="margin-top:20px">
                    	<div class="InfoScreen">
                    		<h2 class="infoScreenHeader"></h2>
                        	<p class="infoScreenSubHeader hide">
                        		<!--<span class="h4">3CSA</span>-->
                        	</p>
                    	</div><!--DIV ENDS FOR INFO SCREEN-->
                	</div> <!--DIV ENDS FOR DISPLAYING THE SELECTED SEMESTERS-->
                    
                    <!--DIV FOR ADDING FACULTY-->
                    <div class="col-sm-12"><!--INFO for adding faculty-->
                    	<div id="AddFaculty" class="col-sm-12 AddFaculty" >
                    		<h4 class="blue-text semAddHeading" style="margin-bottom:18px;" > + Add Faculty</h4>
                        	<input type="text" class="form-control faculty-dept-entry "  placeholder="First Name">
                        	<input type="text" class="form-control faculty-dept-entry" placeholder="Last Name">
                        	<input type="text" class="form-control faculty-dept-entry" placeholder="User Name">
                    		<button type="button" class="btn btn-primary jecrc-create-btn">Create</button>
                    	</div><!--DIV ENDS FOR ADDING FACULTY-->
                    </div>
            	</div><!--<!--DIV ENDS FOR CREATING DEPT AND OTHER FIELDS-->
                
         	</div><!--DIV ENDS FOR ANOTHER ROW-->
		</div><!--END of col-sm-10 col-md-10 class DIV-->
	</div><!--End of Main row div-->
</div><!--End of container-fluid div-->




<?php
require_once 'modules/template.php';
require_once 'modules/footer.php';
?>

<?php
 }
	 else{
		 echo "Error: You are not authorised to view this page..";
	 	header('Location: modules/faculty.php');
 	}
}
?>