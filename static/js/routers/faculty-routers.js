// JavaScript Document

//Routers...
//Residing everything under a global namespace "app"
//var app = app || {};

app.Routers =  app.Routers || {};

//Defining routers here...
app.Routers = Backbone.Router.extend({
	routes:{
		"department/:name" : "showDepartment",
		"department/:dept_name/semester/:semester_name/section/:section_name" : "FacultyEntry",
		"*path":	"ShowLogActivity"
	},
	
	
	
	ShowLogActivity: function(){
		console.log('loading the default route..');
		//Loading the homepage view...
		app.home = new app.Views.activity({collection : app.Global.entryLogCollection});
	},
	
	
	FacultyEntry : function(dept_name, semester_name, section_name ){
		  if(app.Global.Department.length === 0)
		  {
			  app.Global.Department.fetch({
				  error: function () {
					  console.log('Error fetching department..');
				  },
				  success: function(){
					  FacultyBranchEntry(dept_name, semester_name, section_name ); 
				  }
			  });
		  }
		  else{
			  
			 FacultyBranchEntry(dept_name, semester_name, section_name ); 
		  }
		
		
	},
	
	
	
	
	
	//ROuter for displaying dapartment...
	showDepartment: function(name){
		//fetching branch and storing it in collection...
		fetchBranch(name);		
	}
});

//Fetching branch...
var fetchBranch = function(name){
	$("#faculty-entry-record").empty();
	//Showing loading bar...
	app.Global.showLoadingBar();
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
				
				app.Global.render_department(name);
			}
			
			
		}
	});
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
		console.log('loading bar is getting hide..');
		app.Global.hideLoadingBar();	
}




var FacultyBranchEntry =  function(dept_name, semester_name, section_name ){
		    app.Global.showLoadingBar();
		    //Now fecthing report collection based on department..
			var periodEntryCollection = new app.Collection.periodEntry;
			//Getting the today date for finding the entry..
			var today_date = getTodayDate();
			//OLD URL periodEntryCollection.url = "department.php/faculty/department/" + dept_name +"/semester/" + semester_name + "/section/" + section_name;
			
			//displaying todayPeriodEntry
			periodDisplay(dept_name, semester_name, section_name, periodEntryCollection );
}


//Function for showing Period render and showing Entry form display form....
var periodDisplay = function( dept_name, semester_name, section_name, Periodcollection ){
	//Now fetching data...		
	Periodcollection.fetch({
		  data:{
			 "dept_name"	  :dept_name,  
			 "sem"		  	  :semester_name,
			 "sec_name"   	  :section_name ,
			 "todayEntry" 	  :'1'
		  },
		  error: function () {
			  app.Global.hideLoadingBar();
			  console.log('Error fetching department wise entry from database..');
		  },
		  success: function(list_array){
			  app.Global.hideLoadingBar();
			  console.log('Successfully fetched faculty today entry data..');
			  $("#faculty-display-screen").empty();
			  var entry_arr  = $.unique(Periodcollection.pluck("days_entry_id"));
			  console.log(entry_arr);
			  if(entry_arr.length)
			  {
				  //Now processing each entry one by one..
				  //<div id="" class="col-md-8 statistics  ">
				  $("#faculty-display-screen").html('');
				 
				  
				  for(var i=0; i<entry_arr.length; i++)
				  {
						  //finding the entry model one by one....
						  var entry_model_arr = Periodcollection.where({ "days_entry_id":entry_arr[i] });
						  //Now load this view..
						  console.log("Getting the entry model arr length");
						  
						  var periodView = new app.Views.periodEntry({collection:entry_model_arr});
						  //app.Global.x = periodView;
						  $("#faculty-display-screen").append(periodView.render().el);
				  }
			  }//End of if
			  else{
				  //load this view..
				  var periodView = new app.Views.periodEntry({collection:[]});
				  $("#faculty-display-screen").append(periodView.render().el);	
			  }
			  
			  
			  //Calling period Entry function..
			  PeriodEntryRender(dept_name, semester_name, section_name, Periodcollection);
		  
		  }
	});	
	
}//Function ends for periodDisplay..


//Function for Entry Form 
var PeriodEntryRender = function(dept_name, semester_name, section_name, Periodcollection){
	
	//Rendering faculty view..
	var dept_model = app.Global.Department.findWhere({"name": dept_name});
	if(dept_model === undefined){
		app.Global.Department.fetch({
			error: function () {
				console.log('Error fetching department..');
			},
			success: function(){
				console.log('Successfully fecthed department data..');
				//calling dapartment...	
				var dept_model = app.Global.Department.findWhere({"name": dept_name});
				
				var infoObject = {
					//semester_name, section_name
					"department_name"  : dept_model.get("name"),
					"department_id"    : dept_model.get("id"),
					"semester_id"      : semester_name,
					"section_name"     : section_name 	
				}
				
				var periodModel = new app.Model.periodEntry(infoObject);
			
				console.log("Rendering the Faculty Entry data..")
				var facultyEntry = new app.Views.FacultyEntry({
					model		 : periodModel,				
					collection   : Periodcollection
					
				});
				
				facultyEntry.render();
			}
		});
	}
	else{
		var infoObject = {
			//semester_name, section_name
			"department_name"  : dept_model.get("name"),
			"department_id"    : dept_model.get("id"),
			"semester_id"      : semester_name,
			"section_name"     : section_name 	
		}
		console.log("I am rendering period entry");
		var periodModel = new app.Model.periodEntry(infoObject);
		var facultyEntry = new app.Views.FacultyEntry({
			model		 : periodModel,				
			collection   : Periodcollection,
			update		 : false
		});
		//Appending view to window..
		$("#faculty-entry-record").html(facultyEntry.render().el);
		
	}	
	
	
}//Function ends for PeriodEntryRender



$(document).ready(function(e) {
    app.Global.Router = new app.Routers();
	Backbone.history.start({root: "/Manage/"}); 
});


