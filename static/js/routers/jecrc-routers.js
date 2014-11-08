//Routers...
//Residing everything under a global namespace "app"
//var app = app || {};

app.Routers =  app.Routers || {};

//Defining routers here...
app.Routers = Backbone.Router.extend({
	routes:{
		""																			 : "showHomePage",			
		"department/:name" 															 : "showDepartment",
		"report/department/:dept_name" 												 : "showDepartmentReport"	,
		"report/department/:dept_name/:year" 										 : "showYearReport",
		"report/department/:dept_name/semester/:semester_name/section/:section_name" : "showBranchReport",
		"settings"																	 : "showSettings"
	},
	
	
	//Area for displaying basic home page...
	showHomePage: function()
	{
		//Unbinding any previous selected scroll events...
		$(window).unbind('scroll');
		this.closePreviousViews();
		
		if(this.DepartmentElementObj && this.DepartmentElementObj.length ){
			$("#right-side-hook").html( this.DepartmentElementObj );
			//this.DepartmentElementObj = null;
		}
		//Now showing the department...
		$("#admin-department").removeClass('hide');
		
		console.log("Loading the activity logs");
		//Loading the activity view...
		var logs = new app.Views.activity({collection : app.Global.entryLogCollection});
		logs.render();
		//Now loading the element...
		$("#jecrc-main-screen").html(logs.el);
		
	},
	
	//For showing the  settings page..
	showSettings: function(){
		//doing some necessary actions...
		//Unbinding any previous selected scroll events...
		$(window).unbind('scroll');
		this.closePreviousViews();
		if(!this.DepartmentElementObj ){
			this.DepartmentElementObj = $("#admin-department").detach();
		}
		else{
			if(!this.DepartmentElementObj.length){
				this.DepartmentElementObj = $("#admin-department").detach();
			}
		}
		
		
		var settings = new app.Views.settings();
		//Loading to main screen..
		//Now loading the element...
		$("#jecrc-main-screen").html( settings.render().el );
		
	},
	
	
	//Always call this function before calling a route call function...
	closePreviousViews: function() {
		console.log("Closing the pervious in memory views...");
		if (this.currentView)
			this.currentView.destroy_view();
	},
	
	
	//Showing report for department..
	showDepartmentReport: function(dept_name){
		//Unbinding any previous selected scroll events...
		$(window).unbind('scroll');
		this.closePreviousViews();
		$("#jecrc-main-screen").empty();
		//Hiding the department...
		$("#admin-department").addClass('hide');
		if(!this.DepartmentElementObj ){
			this.DepartmentElementObj = $("#admin-department").detach();
		}
		else{
			if(!this.DepartmentElementObj.length){
				this.DepartmentElementObj = $("#admin-department").detach();
			}
		}
		
		
		
		data = {
				
						offset	   : 0,
						limit	   : 5, 
						"dept_name": dept_name
					
				};
		//Now fecthing and rendering periodentryCollection..
		PeriodEntryRender( data );
		
	},
	
	
	showBranchReport: function(dept_name, semester_name, section_name ){
		//Unbinding any previous selected scroll events...
		$(window).unbind('scroll');
		//this.closePreviousViews();
		//Hiding the department...
		this.closePreviousViews();
		$("#admin-department").addClass('hide');
		$("#jecrc-main-screen").empty();
		
		if(!this.DepartmentElementObj ){
			this.DepartmentElementObj = $("#admin-department").detach();
		}
		else{
			if(!this.DepartmentElementObj.length){
				this.DepartmentElementObj = $("#admin-department").detach();
			}
		}
		
		
		//Now fecthing report collection based on department..
			var periodEntryCollection = new app.Collection.periodEntry;
			
			//$_GET['dept_name']) && isset($_GET['sem']) && isset($_GET['sec_name']
			data = {
				
						offset	   : 0,
						limit	   : 5, 
						"dept_name": dept_name,
						"sem"	   : semester_name,
						"sec_name" : section_name
				
				};
			
		//Now fecthing and rendering periodentryCollection..
		PeriodEntryRender( data );
		
		
	},
	
	
	showYearReport: function(dept_name, year){
		//Unbinding any previous selected scroll events...
		$(window).unbind('scroll');
		this.closePreviousViews();
		$("#jecrc-main-screen").empty();
		//Hiding the department...
		$("#admin-department").addClass('hide');
		if(!this.DepartmentElementObj ){
			this.DepartmentElementObj = $("#admin-department").detach();
		}
		else{
			if(!this.DepartmentElementObj.length){
				this.DepartmentElementObj = $("#admin-department").detach();
			}
		}
		
		data = {
					
						offset	   : 0,
						limit	   : 5, 
						"dept_name": dept_name,
						"year"     : year
					
				};
		
		
		
		//Now fecthing and rendering periodentryCollection..
		PeriodEntryRender( data );
		 
	},
	
	
	
	showDepartment: function(name){
		//Unbinding any previous selected scroll events...
		$(window).unbind('scroll');
		this.closePreviousViews();
		$("#jecrc-main-screen").empty();
		//Hiding the department...
		$("#admin-department").addClass('hide');
		if(!this.DepartmentElementObj ){
			this.DepartmentElementObj = $("#admin-department").detach();
		}
		else{
			if(!this.DepartmentElementObj.length){
				this.DepartmentElementObj = $("#admin-department").detach();
			}
		}
		
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



//collection.fetch({data: {offset: 30, limit:30, faculty_id:id_of_faculty}, add: true})
//Route function for rendering period entry data...
//Here data is for adding the page rendering info like department name, year name etc and also for offset and limit info 
var PeriodEntryRender = function( data ){
	app.Global.showLoadingBar();
	if(app.Global.Department.length === 0){
		app.Global.Department.fetch({
			error  : function()
			{
				console.log("Error fetching the department..");
				app.Global.hideLoadingBar();
			},
			success: function()
			{
				app.Global.hideLoadingBar();
				console.info("Successfully fetched  department data");
				fetchPeriod( data );
				
			},
		});
	}
	else{
		fetchPeriod( data );	
	}
	
				
}//Function end for periodEntryRender..



var fetchPeriod = function( data ){
	
	//Now creating the collection......
	var PeriodCollection = new app.Collection.periodEntry;
	PeriodCollection.data  = data;
	$("#jecrc-main-screen").html('');
	//Now load this view..
	var periodView = new app.Views.periodEntry({ collection:PeriodCollection });
	
}



app.Global.render_department =  function(name){
		var dept_id = app.Global.Department.findWhere({"name": name}).get("id");
		if(dept_id === undefined)
			return null;
			
		var cs_department = app.Global.Branch.where({"department_id" : dept_id});
		var cs_branch_collection = new app.Collection.Branch(cs_department); 
		//Now rendering the batch view...
		var cs_branch_view = new app.Views.Branch({"collection": cs_branch_collection});
		cs_branch_view.render();
		//Adding the element to the page...
		$("#jecrc-main-screen").html(cs_branch_view.el);
		console.log('loading bar is getting hide..');
		app.Global.hideLoadingBar();	
}

$(document).ready(function(e) {
    app.Global.Router = new app.Routers();
	Backbone.history.start({root: "/Manage/"}); 
});
