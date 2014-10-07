//Routers...
//Residing everything under a global namespace "app"
//var app = app || {};

app.Routers =  app.Routers || {};

//Defining routers here...
app.Routers = Backbone.Router.extend({
	routes:{
		"department/:name" : "showDepartment",
		"report/department/:dept_name" : "showDepartmentReport"	,
		"report/department/:dept_name/:year" : "showYearReport",
		"report/department/:dept-name/semester/:semester-name/section/:section-name" : "showBranchReport"
	},
	
	//Showing report for department..
	showDepartmentReport: function(dept_name){
		
		
	},
	
	
	
	
	showDepartment: function(name){
		//Showing loading bar..
		app.Global.showLoadingBar();
		//fetching branch and storing it in collection...
		app.Global.Branch.fetch({
		error: function () {
			app.Global.hideLoadingBar();
			console.log('Error fetching branch from database..');
		},
		success: function(list_array){
			console.log('Successfully fetched branch data..');
			//Now select cs branch from that model..
			//filtering models...
			//app.Global.Department.fetch();
			if (app.Global.Department.findWhere({"name": name}) === undefined)
			{
				//fetch department..
				app.Global.Department.fetch({
					error: function () {
						console.log('Error fetching department..');
					},
					success: function(){
						console.log('Successfully fecthed department data..');
						//calling dapartment...	
						app.Global.render_department(name);
					}
				});
				console.log("returning null");
			}
			else
			{
				//Just call department..
				console.log('Simply calling department..');
				app.Global.render_department(name);
			}
			
			
		}
	
		
	});
	
		
	}
	
	
	
});

app.Global.render_department =  function(name){
		var dept_id = app.Global.Department.findWhere({"name": name}).get("id");
		if(dept_id === undefined)
			return null;
			
		var cs_department = app.Global.Branch.where({"department_id" : dept_id});
		var cs_branch_collection = new app.Collection.Branch(cs_department); 
		//Now rendering the batch view...
		var cs_branch_view = new app.Views.Branch({"collection": cs_branch_collection});
		cs_branch_view.render();
		console.log('loading bar is getting hide..');
		app.Global.hideLoadingBar();	
}


app.Global.Router = new app.Routers();
Backbone.history.start();