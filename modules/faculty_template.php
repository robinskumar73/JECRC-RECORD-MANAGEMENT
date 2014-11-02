<script type="text/template"  id="faculty-table-data">
	<h4 class="log_day"> <%= day %> </h4>
	  <span class="log_date"  > <%= date %> </span>
	  <div class="col-md-12 jecrc-stats">
		  <div class="table-responsive">
			<table class="table table-striped">
				<thead>
					<tr style="height:37px;">
						<th>I</th>
						
					</tr>
				</thead>
				<tbody>
					  <tr style="height:37px;">
						  <td></td>
						 
					  </tr>
					  <tr style="height:37px;">
						  <td></td>
						 
					  </tr>
					  <tr style="height:37px;">
						  <td class="faculty_name_tuple" data-toggle="tooltip" data-placement="top" title="Loading.."> <%= faculty %> </td>
						
					  </tr>
				  </tbody>
  			</table>
		</div><!--DIV ENDS FOR TABLE RESPONSIVE-->
	</div>					
</script>


<!--Template for  single NavLink-->
<script type="text/template" id="branch-template">
		<div class="col-md-12">
		  <div class="col-md-12">
		  <a id="branch-template-department-name" class="h4 link" href="#" style="cursor:pointer;"><%= department %></a>
		  <hr>
		  <% _.each(years, function(year){ %>
		  	<div class="col-md-3">
			 
		  		<a id="branch-template-year-name" href="#" class="h4 yearname link alert-link" style="cursor:pointer;"> <%= year.yearname %> </a>
		  		<hr>
			
			   	<% _.each(year.branches, function(branch){ var branch_ = parseBranch(branch.name); %>
				
            		<a id="branch-template-branch-name" class="alert h5 alert_link <%= app.Global.alertType[app.Global.randomNumber(0,4)] %>  batch_display " style="cursor:pointer;" href="#department/<%= department %>/semester/<%= branch_[0] %>/section/<%= branch_[2] %>" > <%= branch.name %>  </a>
       	 	   <% }); %>
			</div>
		  	<% }); %> 
			              
      		</div>      
    	</div>
</script>



