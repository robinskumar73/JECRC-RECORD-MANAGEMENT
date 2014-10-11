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
