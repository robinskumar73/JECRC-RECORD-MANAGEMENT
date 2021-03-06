<!--Template for  single NavLink-->
<script type="text/template" id="branch-template">
		<div class="col-md-12">
		  <div class="col-md-12">
		  	<div id="display-info-box">  </div>
		  <a id="branch-template-department-name" class="h4 link" href="#report/department/<%= department %>" style="cursor:pointer;display:inline-block"><%= department %>
		  	
		  </a>
		  <span class="glyphicon glyphicon-pencil branch-edit-icon hide" ></span>
		  <hr style="margin-top:0px;">
		  <% _.each(years, function(year){ %>
		  	<div class="col-md-3">
		  		<a id="branch-template-year-name" href="#report/department/<%= department %>/<%=  year.yearname %>" class="h4 yearname link" style="cursor:pointer;"> <%= year.yearname %> </a>
		  		<hr>
			
			   	<% _.each(year.branches, function(branch){ var branch_ = parseBranch(branch.name); %>
				
            		<a id="branch-template-branch-name" class="alert h5 alert_link <%= app.Global.alertType[app.Global.randomNumber(0,4)] %>  batch_display " style="cursor:pointer;" href="#report/department/<%= department %>/semester/<%= branch_[0] %>/section/<%= branch_[2] %>" > <%= branch.name %> 
						<span id="branch-remove-icon" class="hide glyphicon branch-remove-icons glyphicon-remove"></span>
					 </a>
       	 	   <% }); %>
			</div>
		  	<% }); %> 
			              
      		</div>      
    	</div>
</script>



<script type="text/template" id="Create-Faculty-Template">
	<!--DIV FOR ADDING FACULTY-->
    <div class="col-sm-12"><!--INFO for adding faculty-->
        <div id="AddFaculty" class="col-sm-12 AddFaculty" >
            <h4 class="blue-text semAddHeading" style="margin-bottom:18px;" > + Add Faculty</h4>
			<div id="admin-faculty-info-box"></div><!-- For displaying info and results..--> 
			<div id="faculty-input-field">
				<input type="text" id="faculty-first-name" class="form-control faculty-dept-entry "  placeholder="First Name">
				<input type="text" id="faculty-last-name"  class="form-control faculty-dept-entry" placeholder="Last Name">
				<input type="text" id="faculty-user-name" class="form-control faculty-dept-entry" placeholder="User Name">
				<input type="text" id="faculty-email-address" class="form-control faculty-dept-entry" placeholder="Email Address">
				<button type="button" id="faculty-create-btn"  class="btn btn-primary jecrc-create-btn">Create</button>
				<button type="button" id="faculty-reset-btn" style="margin-right:15px;" class="btn btn-primary jecrc-create-btn">Reset</button>
			</div><!---END OF FACULTY INPUT FIELD-->
        </div><!--DIV ENDS FOR ADDING FACULTY-->
    </div>
</script>


<!---template for adding the settings--->
<script type="text/template" id="template-reset-settings">
	<!--DIV FOR ADDING FACULTY-->
    <div class="col-sm-12" id="reset-settings">
			<div id="settings-delete-info"></div>
			<h4 class="blue-text semAddHeading" style="margin-bottom:18px;" > Do you want to reset entry? </h4>
			<button type="button" id="settings-delete-btn"  class="btn btn-danger">Delete</button>
		    <a href="#"><button type="button" id="settings-cancel-btn" style="margin-left:15px;"  class="btn btn-success">Get me out of here</button></a>
	</div>
</script>


<!--TEMPLATE FOR FACULTY LIST-->
<script id="faculty-list-item" type="text/template">
	
	 <h4 id="faculty-list-item-full-name" style="margin-bottom:0px;"><%= name %></h4>
	 <div id="faculty-edit-list" style="display:block;" class="hide">
	 	 <h4  style="margin-bottom:0px;">Edit faculty</h4>	
		 <input type="text" id="faculty-edit-first-name" value="<%= first_name %>" class="form-control  jecrc-dept-entry" placeholder="First Name">
		 <input type="text" id="faculty-edit-last-name" value="<%= last_name %>" class="form-control jecrc-dept-entry" placeholder="Last Name">
		 <input type="text" id="faculty-edit-username" value="<%= username %>" class="form-control jecrc-dept-entry" placeholder="Username">
		 <input type="text" id="faculty-edit-email-address" value="<%= email_address %>" class="form-control  jecrc-dept-entry" placeholder="Email Address">
		 <button type="button" id="faculty-create-btn"  class="btn btn-primary jecrc-create-btn">Update</button>
		 <button type="button" id="faculty-reset-btn" style="margin-right:15px;" class="btn btn-primary jecrc-create-btn">Cancel</button>
	 </div>
	 <p>
		 <span  id="faculty-item-delete" class="faculty-list-icons glyphicon glyphicon-trash"></span>
		 <span  id="faculty-item-edit" class="faculty-list-icons glyphicon glyphicon-pencil"></span>
	 <p>
	  <div id="faculty-list-item-display-info" style="margin-left:0px;margin-bottom:10px; margin-top:10px"> </div>	
</script>




<script id="faculty-list-collection" type="text/template">
	<!--DIV FOR ADDING FACULTY-->
    <div class="col-sm-12"><!--INFO for adding faculty-->
        <div id="FacultyList" class="col-sm-12 AddFaculty" >
            <h4 class="blue-text semAddHeading" style="margin-bottom:18px;" > Faculty List </h4>
            <ul class="faculty-list">
              <!--Add the list items to create list of faculty-->
            </ul>
        </div><!--DIV ENDS FOR ADDING FACULTY-->
   </div>
</script>


<!--For displaying of alert messages--->
<script id="display-info" type="text/template">
	<div id="dept-display-box" class=" alert <%= typeInfo %> fade in" role="alert">
      		<button type="button" class="close" data-dismiss="alert">
				<span aria-hidden="true">×</span><span class="sr-only">Close</span>
			</button>
			<div class="alert-body">
      			<%= message %>
			</div>
    </div>
</script>



<!--Template for creating faculty entry log -->
<script id="faculty_home_log" type="text/template">
	<div class="log-entry-circle"></div>
	<blockquote  class="log-entry">
		<p> <%- info %> </p>
		<footer> <%- entry_type %>  <cite title="Source Title"> <%- sub_info %> </cite></footer>
	</blockquote> 					  
</script>



<script id="entry-log-alert-body" type="text/template">
	<div class="delete-info">
  		<h4> Do you want to delete this entry. </h4>
  		<p>
			<button type="button" id="entry-action-btn" class="btn btn-danger"> Delete </button>
  		</p>
  	</div>
</script>


<script id="delete-entry-alert-body" type="text/template">
	<div class="settings-delete-info">
  		<h4> Do you want to reset entry. </h4>
  		<p>
			<button type="button" id="entry-action-btn" class="btn btn-danger"> Delete </button>
  		</p>
  	</div>
</script>



<script id="alert-password-confirm-modal" type="text/template">
  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header">
		  	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		   	<h4 class="modal-title" id="myModalLabel">
		  		 Confirm your password to proceed
		   	</h4>
		</div>
		<div class="modal-body">
		  <!--Modal body --->
		   <input type="password" id="pass-confirm" class="form-control  jecrc-dept-entry" placeholder="Confirm password">
		</div>
		<div class="modal-footer">
		  <button id="alert_modal_save_btn" type="button" class="btn btn-primary">Confirm Password</button>
		</div>
	  </div>
	</div>
  </div>
</script>


