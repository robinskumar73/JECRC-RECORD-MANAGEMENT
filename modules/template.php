<!--Template for  single NavLink-->
<script type="text/template" id="branch-template">
		<div class="col-md-12">
		  <div class="col-md-12">
		  <h4 id="branch-template-department-name" style="cursor:pointer;"><%= department %></h4>
		  <hr>
		  <% _.each(years, function(year){ %>
		  	<div class="col-md-3">
		  		<h4 id="branch-template-year-name" class="yearname" style="cursor:pointer;"> <%= year.yearname %> </h4>
		  		<hr>
			
			   	<% _.each(year.branches, function(branch){ %>
            		<h5 id="branch-template-branch-name" class="alert <%= app.Global.alertType[app.Global.randomNumber(0,4)] %>  batch_display " style="cursor:pointer;" > <%= branch.name %>  </h5>
       	 	   <% }); %>
			</div>
		  	<% }); %> 
			              
      		</div>      
    	</div>
</script>
