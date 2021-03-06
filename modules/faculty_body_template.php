<script id="faculty-entry-form" type="text/template">
	<div class="col-md-12" >
		<h4 id="faculty_attendance_heading4"> <%- department %></h4>
		
        <p id="dept-info-box"> <!--For displaying info and results--> </p>
		
		
		
		<div class="col-md-12 jecrc-stats">
			<div id="jecrc-div-entry-typeahead">
				<input type="text" id="jecrc-subject-entry" class="form-control jecrc-dept-entry" placeholder="Subject Name">
				 <br />
				 <div class="col-sm-12">
					  <div class="btn-group active classlab" style="margin-bottom:20px;" data-toggle="buttons">
						  <label class="btn btn-default" id="class-label">
							  <input type="radio"  name="options" id="class"  checked> Class
						  </label>
						  <label class="btn btn-default" id="lab-label">
							  <input type="radio" name="options" id="lab"> Lab
						  </label>
					  </div> 
				  </div>
				  
				 <div class="btn-group batch col-sm-12 hide" id="jecrc-batch-entry" style="margin-bottom:20px;display:block" data-toggle="buttons">
					  	  <h4 style="display:block" class="blue-text semAddHeading">Select Batch</h4>
						 
						  <label class="btn btn-primary" >
							  <input type="radio"  name="options" value="1"> 1
						  </label>
						  <label class="btn btn-primary">
							  <input type="radio" name="options" value="2"> 2
						  </label>
						  
						  <label class="btn btn-primary">
							  <input type="radio" name="options" value="3"> 3
						  </label>
						  
						  <label class="btn btn-primary">
							  <input type="radio" name="options" value="4"> 4
						  </label>
						  <label class="btn btn-primary">
							  <input type="radio" name="options" value="5"> 5
						  </label>
						  <label class="btn btn-primary">
							  <input type="radio" name="options" value="6"> 6
						  </label>
						
				</div>  
				  
				<div id="AddBatches" style="margin-bottom:20px;" class="col-sm-12 AddBatches">
					  <h4 style="display:block" class="blue-text semAddHeading">Select Periods</h4>
					  <div class="btn-group" data-toggle="buttons">
						  <label class="btn btn-primary dept-check " data-wat="1">
							  1
						  </label>
						  <label class="btn btn-primary dept-check " data-wat="2">
							   2
						  </label>
						  <label class="btn btn-primary dept-check" data-wat="3">
							  3
						  </label>
						  <label class="btn btn-primary dept-check" data-wat="4">
							  4
						  </label>
						  <label class="btn btn-primary dept-check" data-wat="5">
							  5
						  </label>
						  <label class="btn btn-primary dept-check" data-wat="6"> 
							  6
						  </label>
					  </div>
					 
				  </div>
	
			  <div class="col-sm-12">
				<input type="text" id="jecrc-strength-entry" style="margin-bottom:20px;" class="form-control jecrc-dept-entry"  placeholder="Strength">
				
				<input type="button" value="Save" id="faculty_save_button" class="btn btn-success faculty_button"></input>
				<input type="button" value="Reset" id="faculty_reset_button" class="btn btn-danger faculty_button"></input>
			  </div>
			</div>
		</div><!--DIV END FOR jecrc-stats-->
	</div>
</script>

<!--Template for creating faculty entry log -->
<script id="faculty_home_log" type="text/template">
	<div class="log-entry-circle"></div>
	<blockquote  class="log-entry">
		<p> <%- info %> </p>
		<footer> <%- entry_type %>  <cite title="Source Title"> <%- sub_info %> </cite></footer>
		<% if(entry_type === 'update' || entry_type === 'entry' || entry_type === 'subject') { %>
			<div id="log-icons-containers" style="margin-left:8px;">
				<a id="log-entry-edit" style="display:inline-block" href="#">
				  <p class="log-entry-icon glyphicon glyphicon-pencil"></p>
				</a> 
				<a id="log-entry-delete" style="display:inline-block" href="#">
				  <p  class="log-entry-icon glyphicon glyphicon-trash"></p>
				</a> 
			</div> 
			
		<% } %>  
	</blockquote> 					  
</script>


<script id="display-info" type="text/template">
	<div id="dept-display-box" style="margin-left:20px;" class=" alert <%= typeInfo %> fade in" role="alert">
      		<button type="button" class="close" data-dismiss="alert">
				<span aria-hidden="true">×</span><span class="sr-only">Close</span>
			</button>
			<div class="alert-body">
      			<%= message %>
			</div>
    </div>
</script>



<script id="entry-log-alert-body" type="text/template">
	<div class="delete-info">
  		<h4> Do you want to delete this entry. </h4>
  		<p>
			<button type="button" id="entry-action-btn" class="btn btn-danger"> Delete </button>
  		</p>
  	</div>
</script>



<script id="alert-modal" type="text/template">
  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		   	<h4 class="modal-title" id="myModalLabel">
		  		 <!-- heading --->
		   	</h4>
		</div>
		<div class="modal-body">
		  <!--Modal body --->
		</div>
		<div class="modal-footer">
		  <button id="alert_modal_close_btn" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  <button id="alert_modal_save_btn" type="button" class="btn btn-primary">Save changes</button>
		</div>
	  </div>
	</div>
  </div>
</script>