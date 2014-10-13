<script id="faculty-entry-form" type="text/template">
	<div class="col-md-12" >
		<h4 id="faculty_attendance_heading4"> <%- department %></h4>
		<!--For displaying info and results-->
        <p id="dept-info-box" class="text-danger col-sm-12 hide" style="text-align:center"></p>
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