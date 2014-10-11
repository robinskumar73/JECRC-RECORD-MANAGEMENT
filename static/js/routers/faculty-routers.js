// JavaScript Document

//Routers...
//Residing everything under a global namespace "app"
//var app = app || {};

app.Routers =  app.Routers || {};

//Defining routers here...
app.Routers = Backbone.Router.extend({
	routes:{
		"department/:name" : "showDepartment",
		"faculty/department/:dept_name/semester/:semester_name/section/:section_name" : "FacultyBranchEntry"
	},
	
	
	
	
	showBranchReport: function(dept_name, semester_name, section_name ){
		//Now fecthing report collection based on department..
			var periodEntryCollection = new app.Collection.periodEntry;
			periodEntryCollection.url = "modules/department.php/entry/department/" + dept_name +"/semester/" + semester_name + "/section/" + section_name;
			//Now fetching data...		
			periodEntryCollection.fetch({
			error: function () {
				app.Global.hideLoadingBar();
				console.log('Error fetching department wise entry from database..');
			},
			success: function(list_array){
				app.Global.hideLoadingBar();
				console.log('Successfully fetched department wise entry data..');
				//Getting the dates of entry in decreasing order..
				var entry_arr  = $.unique(periodEntryCollection.pluck("days_entry_id"));
				//app.Global.entry_model = entry_arr;
				//Now processing each entry one by one..
				//<div id="" class="col-md-8 statistics  ">
				$("#jecrc-main-screen").html('');
				app.Global.arr = [];
				for(var i=0; i<entry_arr.length; i++)
				{
						//console.log("I am looping");
						//finding the entry model one by one....
						var entry_model_arr = periodEntryCollection.where({ "days_entry_id":entry_arr[i] });
						//Now load this view..
						var periodView = new app.Views.periodEntry({collection:entry_model_arr});
						$("#jecrc-main-screen").append(periodView.render().el);
						$(".report-dept-info").addClass('hide');
				}
			}
		});
		
		
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

$(document).ready(function(e) {
   app.Global.Router = new app.Routers();
   Backbone.history.start(); 
});
