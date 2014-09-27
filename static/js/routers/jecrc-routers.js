//Routers...
//Residing everything under a global namespace "app"
//var app = app || {};

app.Routers =  app.Routers || {};

//Defining routers here...
app.Routers = Backbone.Router.extend({
	routes:{
		"department/:name" : "showDepartment"	
	},
	
	showDepartment: function(name){
		//fetching branch and storing it in collection...
		app.Global.Branch.fetch({
		error: function () {
			console.log('Error fetching branch from database..');
		},
		success: function(list_array){
			console.log('Successfully fetched branch data..');
			//Now select cs branch from that model..
			//filtering models...
			//app.Global.Department.fetch();
			if (app.Global.Department.findWhere({"name": name}) === undefined)
				return null;
			var dept_id = app.Global.Department.findWhere({"name": name}).get("id");
			if(dept_id === undefined)
				return null;
				
			var cs_department = app.Global.Branch.where({"department_id" : dept_id});
			var cs_branch_collection = new app.Collection.Branch(cs_department); 
			//Now rendering the batch view...
			var cs_branch_view = new app.Views.Branch({"collection": cs_branch_collection});
			cs_branch_view.render();
			
		}
	
		
	});
	
		
	}
});

app.Global.Router = new app.Routers();
Backbone.history.start();