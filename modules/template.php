<!--Template for  single NavLink-->
<script type="text/template" id="branch-template">
		<div class="col-md-12">
		  <div class="col-md-12">
		  <a id="branch-template-department-name" class="h4 link" href="#report/department/<%= department %>" style="cursor:pointer;"><%= department %></a>
		  <hr>
		  <% _.each(years, function(year){ %>
		  	<div class="col-md-3">
		  		<a id="branch-template-year-name" href="#report/department/<%= department %>/<%=  year.yearname %>" class="h4 yearname link" style="cursor:pointer;"> <%= year.yearname %> </a>
		  		<hr>
			
			   	<% _.each(year.branches, function(branch){ var branch_ = parseBranch(branch.name); %>
				
            		<a id="branch-template-branch-name" class="alert h5 alert_link <%= app.Global.alertType[app.Global.randomNumber(0,4)] %>  batch_display " style="cursor:pointer;" href="#report/department/<%= department %>/semester/<%= branch_[0] %>/section/<%= branch_[2] %>" > <%= branch.name %>  </a>
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


<!--TEMPLATE FOR FACULTY LIST-->
<script id="faculty-list-item" type="text/template">
	 <div id="faculty-list-item-display-info" style="margin-bottom:3px;"> </div>
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
	<div id="dept-display-box" style="margin-left:20px;" class=" alert <%= typeInfo %> fade in" role="alert">
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




