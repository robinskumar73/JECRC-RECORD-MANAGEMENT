<script type="text/template"  id="faculty-table-data">
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
</script>


<!--Template for  single NavLink-->
<script type="text/template" id="branch-template">
		<div class="col-md-12">
		  <div class="col-md-12">
		  <a id="branch-template-department-name" class="h4 link" href="#faculty/department/<%= department %>" style="cursor:pointer;"><%= department %></a>
		  <hr>
		  <% _.each(years, function(year){ %>
		  	<div class="col-md-3">
		  		<a id="branch-template-year-name" href="#faculty/department/<%= department %>/<%=  year.yearname %>" class="h4 yearname link" style="cursor:pointer;"> <%= year.yearname %> </a>
		  		<hr>
			
			   	<% _.each(year.branches, function(branch){ var branch_ = parseBranch(branch.name); %>
				
            		<a id="branch-template-branch-name" class="alert h5 alert_link <%= app.Global.alertType[app.Global.randomNumber(0,4)] %>  batch_display " style="cursor:pointer;" href="#faculty/department/<%= department %>/semester/<%= branch_[0] %>/section/<%= branch_[2] %>" > <%= branch.name %>  </a>
       	 	   <% }); %>
			</div>
		  	<% }); %> 
			              
      		</div>      
    	</div>
</script>



