// JavaScript Document
// js/views/hashbang-view
// Script written by Robins Gupta.

//Residing everything under a global namespace "app"


//Residing everything under a global namespace "app"
var app = app || {};

//Creating an object for Views....
app.Views = app.Views || {};

//Now create a global variable accesing department list..
app.Global = app.Global || {};

app.Global.Department     = new app.Collection.Department;
app.Global.Branch         = new app.Collection.Branch;
app.Global.Subjects       = new app.Collection.Subject;
app.Global.DepartmentPresentAlready = false;

//Now creating a views structure for VOTES FLAG 
app.Views.Department = Backbone.View.extend({
	
	el: $("#DepartmentCreate"),
	
    events: {
	  //Event for thumb-up
      "click #create-dept"   : "createDepartment",
	  "keypress #Department"   : "handleKeyPress",
	  "click #Dept-Cancel" : "cancel_department",
	 
    },
	
	
	

	
	//function for creating department...
	createDepartment: function(){
		//checking the value of input box..
		app.Global.DepartmentPresentAlready = false;
		app.Global.selDeptModel = null;
		
		value = $("#Department").val();
		
		if(value === ''){
			return null;
		}
		
		//Now begin department creating process...
		//hide the input bar..
		$($('#DepartmentCreate ').children()).addClass('hide');
		$('#Dept-Cancel').removeClass('hide');
		$('#dept-screen').removeClass('hide');
		//Now disabled the nav button of creating department..
		$('a.navbar-text navbar-right jecrc-nav-dept').click(function(e){
			e.preventDefault();	
		});
		
		//Show ADD semester...
		$('#AddSemester').removeClass('hide');
		//Showing to info screen..
		$('#infoScreen').removeClass('hide');
		
		$('.infoScreenHeader').html(value);
		
		//first find if department name already exist..
		if( app.Global.Department.findWhere({'name': value}) !== undefined ){
			app.Global.selDeptModel = app.Global.Department.findWhere({'name': value});
			app.Global.DepartmentPresentAlready = true;
			return null
		}
		
		//Now add this department to department collection..
		app.Global.Department.create({name:value}, {
    	error: function (model, response) {
			displayMessage('Error saving department..');
			revertDeptToInitial();
			//var child = $("#nav-dept-bar").children().length;
			//$($("#nav-dept-bar").children()[child-1]).remove();
    	},
		success: function(model){
			console.log("Successfully added department to database..");
			displayMessage("Successfully added department to database..");
			app.Global.selDeptModel = model;
		}
		});
		
		

	},
	
	render: function(){
		$("#nav-dept-bar").html('');
		var len = app.Global.Department.length;
		for(var i = 0; i< len ; i++)
		{
			$("#nav-dept-bar").append('<li><a href="#department/' + app.Global.Department.at(i).get("name")  +  '"  >' + app.Global.Department.at(i).get("name") + '</a></li>');
		}
		return this;
		
	},
	
	handleKeyPress:function(e){
		var key = e.which;
 		if(key == 13)  // the enter key code
  		{
			this.createDepartment();
		}
	},
	
	
	
	cancel_department:function(e){
		//remove the collection...
		e.preventDefault();
		
		var len =  app.Global.Department.length;
		if(!app.Global.DepartmentPresentAlready && app.Global.Department.at(len-1) === app.Global.selDeptModel ){
			var model_ = app.Global.Department.pop();
			var child = $("#nav-dept-bar").children().length;
			$($("#nav-dept-bar").children()[child-1]).remove();
			
		}
		
		revertDeptToInitial();
		hideBatch();
		hideSection();
		
	},
	
	
	//Now listen to change...
	initialize: function( ) {
	  this.listenTo(app.Global.Department, 'add', this.displayNavigationBar);
	  //this.listenTo(app.Global.Department, 'change', this.displayNavigationBar);
	  this.listenTo(app.Global.Department, 'remove', this.removeNavigationBar); 
    },
	
	
	removeNavigationBar:function(model_){
		//Remove only if department doesnot exist earlier..
		if(!app.Global.DepartmentPresentAlready){
			console.log('repetition not found');
			//Now destroying that model from server..
			model_.destroy({
				error: function (model, response) {
					displayMessage('Error removing department..');
					app.Global.Department.add(model);  
				},
				success:function(model,response){
					console.log('Successfully deleted department..');
					displayMessage('Successfully deleted department..');
				}
			});
			/*
			var child = $("#nav-dept-bar").children().length;
			$($("#nav-dept-bar").children()[child-1]).remove();
			*/
		}
		
	},
	
	
	displayNavigationBar: function(model_){
		//First save this model to the server..
		value = model_.get('name');
		$("#nav-dept-bar").append('<li><a href="#department/' + value  +  '"  >' + value	+ '</a></li>');
	},
	//END of display navigation function...
	
	
	

}); 





var displayMessage = function(message){
	//Callback for success 
	$('#dept-info-box').removeClass('hide');
	$('#dept-info-box').html(message)
	setTimeout(function(){$('#dept-info-box').addClass('hide');}, 4000);
}

var revertDeptToInitial =  function(){
		
		//Now begin department creating process...
		//hide the input bar..
		$("#Department").val('');
		$($('#DepartmentCreate ').children()).removeClass('hide');
		$('#Dept-Cancel').addClass('hide');
		$('#dept-screen').addClass('hide');
		
		//Now binding click event to nav button of creating department..
		$('a.navbar-text navbar-right jecrc-nav-dept').bind('click');
		
		//Show ADD semester...
		$('#AddSemester').addClass('hide');
		//Showing to info screen..
		
}

var dept_views = new app.Views.Department();
//dept_views.render();


//---------------------------------------------------VIEWS ENDS FOR DEPARTMENT---------------------------------------------

//View for Adding Semester...
app.Views.Semester = Backbone.View.extend({
	
	el: $("#radio-btn"),
	
    events: {
	  //Event for thumb-up
      "change input[name=options]"   : "addSemester"
    },
	
	addSemester: function(event){
		var id_ = $('.radio:checked').val();
		app.Global.semester_id = id_;
		
		//getting department model..
		var model_ = app.Global.selDeptModel;
		var dept_name =  model_.get('name');
		/*
		//Now adding semester to department model..
		//model_.Semester.set({'id':id_, 'name': id_});
		*/
		//Now schowing section..
		this.showSection()
		//Updating the info screen..
		this.updateInfoBox(dept_name, id_);
	},
	
	showSection: function(){	
		$("#AddSection").removeClass('hide');
	},

	
	updateInfoBox: function(dept,sem){
		$(".infoScreenHeader").html('' + sem + '' +dept + '');	
	}
	
});



var semesterView = new app.Views.Semester;

//-----VIEW ENDS FOR SECTION------------

//View for Adding Section...
//Adding events on section..
$(document).on('change','#section-btn input[name=options]',function(){
		var sem = app.Global.semester_id;
		var id_ = $(this).val();
		app.Global.section_id = id_;
		
		
		var model_ = app.Global.selDeptModel;
		var dept =  model_.get('name');
		//Now adding semester to department model..
		//model_.Section.set([{'id':id_, 'name': id_}]);
		//Now schowing section..
		showBatch();
		//Updating the info screen..
		$(".infoScreenHeader").html( sem + dept + id_  );
});

var showBatch =  function(){	
		$("#AddBatches").removeClass('hide');
};
var hideBatch = function(){
	$("#AddBatches").addClass('hide');
	$("#publish-batch").addClass('hide');	
};
var hideSection = function(){
	$("#AddSection").addClass('hide');	
}

//--------VIEW FOR BATCH-------------------


//View for Adding Semester...
app.Views.Batch = Backbone.View.extend({
	
	el: $("#AddBatches"),
	
	events: {
		"click .dept-check " :  "onClick"	
	},
	
	
	
	onClick: function(e){
    	setTimeout(this.count);
	},

	count : function(){
    	var val = [];
		$('.infoScreenSubHeader').html('');
    	$('.dept-check').each(function(i, btn){
        	if($(btn).hasClass('active') ){
            	val.push($(btn).data('wat'));
				//updating to info screen
				showinfoScreenSubHeader();
				//<span class="h4">3CSA</span>
				//getting department model..
				var model_ = app.Global.selDeptModel;
				var dept =  model_.get('name');
				$('.infoScreenSubHeader').append('<span class="h4">' + app.Global.semester_id + dept + app.Global.section_id + $(btn).data('wat') + '</span>');
        	}
			
		});
		app.Global.Batches = val;
		
	},
	
	
});

var batch = new app.Views.Batch;
var showinfoScreenSubHeader =  function(){
		$('.infoScreenSubHeader').removeClass('hide');
		$('#publish-batch').removeClass('hide');
}

//Saving batch on click of button..
$(document).on('click','#publish-batch',function(e){
	
	var batches = app.Global.Batches;
	var sem = app.Global.semester_id;
	var dept = app.Global.selDeptModel;
	//console.log(dept.get("id"));
	//app.Global.x = dept;
	var section = app.Global.section_id;
	//For each batches..
	$('.dept-check').each(function(i, btn){
        	if($(btn).hasClass('active') ){
				//Add to batch collection..
				var val = $(btn).data('wat');
				//Now saving the branch to  collection..
				app.Global.Branch.create({
					"department_id":dept.get("id"),
					"semester_id":sem,
					"section_name":section,
					"batch_id":val 
				},{
				error: function (model, response) {
						displayMessage('Error saving Branch..');
						$("#Dept-Cancel").click();
						
						//Revert back
						
    				},
					success: function(model){
						displayMessage("Successfully added branch to database..");
						hideBatch();
						hideSection();
						$('#infoScreen').addClass('hide');
						$('#AddSemester').addClass('hide');
						$('#dept-screen').addClass('hide');
						$('#Dept-Cancel').addClass('hide');
						$('#Department').removeClass('hide');
						
						$('#Department').val('');
						$('#create-dept').removeClass('hide');
						$('#DepartmentCreate').removeClass('hide');
						$("span.twitter-typeahead").removeClass('hide')
					}	
				});
			}
	});//End of each function..
	
});

//------------------------VIEW FOR DISPLAYING PERIOD ENTRY-----------------
app.Views.periodEntry = Backbone.View.extend({
	
	tagName:"div",
	
	className: "col-md-12",
	
	initialize:function(){
		
		if (this.collection.length === 0){
			var name      = faculty.first_name + " " + faculty.last_name; 
			this.name      = getInitialFacultyName(name);
			var date      = getTodayDate();
			this.day      = getDay(date);
			this.date     = convertDate(date);
			this.template =  _.template( $("#faculty-table-data").html() );
			this.template = this.template({"day":this.day, "date": this.date, "faculty": this.name});
		}
		else
		{
			//For checking the lab table..
			this.lab = {row0:null,row1:null,row2:null};
			
			this.periodList   = $("<tr/>");
			this.subjectList  = $("<tr/>");
			this.strengthList = $("<tr/>");
			this.teacherList  = $("<tr/>");
			
			//Inserting date
			this.date           =  this.collection[0].get("date");
			this.department_name  =  app.Global.Department.findWhere({ "id":this.collection[0].get("department_id") }).get("name");
			this.section_name   =  this.collection[0].get("section_name");
			this.semester_id    =  this.collection[0].get("semester_id");
			this.day            =  getDay(this.date);
			this.parse_date	    =	convertDate(this.date);
		}
		
	},//End of initialize function..
	
	
	render:function(){
		$(this.el).empty();
		
		if (this.collection.length === 0){
				this.$el.append(this.template);
				return this;
		}
		
		
		//inserting period data..
		this.addToList(this.collection);
		//Now adding date..
		this.addBody(this.day, this.parse_date);
		//Adding headers...
		var headers = $("<thead />");
		var body_ = $("<tbody />");
		headers.append(this.periodList);
		this.table.append(headers);
		body_.append(this.subjectList);
		body_.append(this.strengthList);
		body_.append(this.teacherList);
		this.table.append(body_);
		return this;	
	},
	
	addBody: function(day, date){
		
		//Adding department..
		this.$el.append( "<h4 class='report-dept-info'>" + this.semester_id + " " + this.department_name  + "</h4>");
		this.$el.append( "<span class='report-dept-info'>" + this.section_name + "</span><hr class='report-dept-info' style='margin-top:0px;margin-bottom:0px;'>");
		
		//Adding day..
		this.$el.append( "<h4>" + day + "</h4>");
		this.$el.append( "<span>" + date + "</span>");	
		var div1   = $("<div class='col-md-12 jecrc-stats' />");
		var div2   = $("<div class='table-responsive'/>");	
		this.table = $("<table class='table table-striped'/>");
		div1.append(div2);
		div2.append(this.table);		
		this.$el.append( div1 );
		this.$el.append( "<br />" )
		
	},
	
	//Adding data to the list...
	addToList: function(modelArray){
		for(var i=0; i<modelArray.length; i++){
			var periodModel = modelArray[i];
			//console.log("I am checking for lab..");
			if(periodModel.get("lab") === "0")
			{
				   //console.log("I am inside if lab= false..");				
				  //Adding period
				  this.periodList.append("<th>" + periodModel.get("period")[0] + "</th>");
				  //Adding subject..
				  this.subjectList.append("<td>" + periodModel.get("subject_name") + "</td>");
				  //Adding subject list..
				  this.strengthList.append("<td>" + periodModel.get("strength") + "</td>");
				  //adding teacher list..
				  this.teacherList.append( "<td>" + getInitialFacultyName( periodModel.get("faculty_name") ) + "</td>" );
			}
			else
			{
				  if(this.lab["row0"] === null)
				  {
					  //Insert lab period..
					  for(var j = 0; j<periodModel.get("period").length; j++)
					  {
						  //Adding period...
						  this.periodList.append("<th>" + periodModel.get("period")[j] + "</th>");
					  }//End of for loop of entering period..
				  }
				  var subject     = periodModel.get("subject_name");
				  var section     = periodModel.get("section_name");
				  var batch		  = periodModel.get("batch");
				  var strength    = periodModel.get("strength");
				  var facultyName = getInitialFacultyName( periodModel.get("faculty_name") );
				  var periodLen   = periodModel.get("period").length;
				  
				  //Now checking for row-to-fill data...
				  if(this.lab["row0"] === null)
				  {	
				  	  
					  row="0";
					   //Adding lab entry..
				  	  this.subjectList.append("<td  colspan='" +periodLen + "'  rowspan='" + row + "'  >" + subject + " -  "+section + batch + " Batch  -" + strength + " - " + facultyName + "</td>" );
					  this.lab["row0"] = true;
					  
				  }
				  else if (this.lab["row1"] === null)
				  {
					  
					  row="1";
					  this.strengthList.append("<td  colspan='" +periodLen + "'  rowspan='" + row + "'  >" + subject + " -  "+section + batch + " Batch  -" + strength + " - " + facultyName + "</td>" );
					  this.lab["row1"] = true;
				  }
				  else
				  {
					 
					  row="2";
					  this.teacherList.append("<td  colspan='" +periodLen + "'  rowspan='" + row + "'  >" + subject + " -  "+section + batch + " Batch  -" + strength + " - " + facultyName + "</td>" );
					  this.lab["row2"] = true;
					  //reset stats..
					  this.lab["row0"] = null;
					  this.lab["row1"] = null;
					  this.lab["row2"] = null;
				  }
				  
				 
					  
			}//End of if-else..
		}//End of for loop..
	}//AddtoList function ends..
	

});



//-------------------------VIEW FOR FACULTY ENTRY--------------------------
app.Views.FacultyEntry = Backbone.View.extend({
	
	//el:$("#faculty-entry-record"),
	
	initialize: function(){
		console.log("Inside facultyEntry constructor");
		this["dept_name"]           =  this.model.get("department_name");
		this["dept_id"]			    =  this.model.get("department_id");
		this["semester_id"]         =  this.model.get("semester_id");
		this["section_name"]        =  this.model.get("section_name");
		
		this.Template            =   _.template( $("#faculty-entry-form").html() );
		this.form 	             =  this.Template( {"department": this.dept_name} );
		var name                 =  faculty.first_name + " " + faculty.last_name; 
		this.FacultyName         =  getInitialFacultyName(name);
		//Get days_entry_id
		if(this.collection.length ){
			this.days_entry_id = this.collection.at(0).get("days_entry_id");
		}
		else{
			this.days_entry_id = "";	
		}

	},
	
	events:{
		"click #lab-label"             : "displayBatch",
		"click #class-label"		   : "handleClassButtonClick",
		"click #faculty_save_button"   : "saveEntry",
		"click #faculty_reset_button"  : "resetEntryValue"
	},
	
	displayBatch: function(){
		$("#jecrc-batch-entry").removeClass("hide");
	},
	
	
	handleClassButtonClick:function(){
		$("#jecrc-batch-entry").addClass("hide");
	},
	
	
	render:function(){
		$(this.el).empty();
		$(this.el).append(this.form);
		//$('input.form-control.jecrc-dept-entry.typeahead').typeahead({
		console.log("Inside facultyEntry render");
		return this;	
	},
	
	
	
	getPeriod : function (){
		var val=[];
		$('.dept-check').each(function(i, btn){
			if($(btn).hasClass('active') ){
				val.push($(btn).data('wat'));
			}
		});
		return val;
	},
	
	getLab:function(){
		if($("#class").attr("checked") === undefined){
			return 1;	
		}
		else {
			return 0;
		}
		
		
	},
	
	saveEntry : function(){
		console.log("Enteries getting saved...");
		this.undelegateEvents();
		var EntryValue = this.getEntryValue();
		if (EntryValue === null){
			return null;	
		}
		else{
			//Updating the url value for post operation..
			var that = this;
			//Creating period entry model...
			var PeriodModel = new app.Model.periodEntry;
			PeriodModel.url = "department.php/entry/department/daysEntry";
			PeriodModel.save(EntryValue,{
				error: function () {
					that.displayMessage('Error saving Entry..');
					
				},
				success: function(){
					console.log("Successfully added Entry to database..");
					that.displayMessage("Successfully added Entry to database..");
					
					//NOW display Batches.. of department..
					//Look for faculty-routers.js for this function..
					//Removing the view..
					that.destroy_view();
					fetchBranch(that.model.get("department_name"));
					//UPdating the URL..
					app.Global.Router.navigate('department/' + that["dept_name"],{trigger:true});
				}
			});
		}
		
		
	},
	
	destroy_view: function() {
		//COMPLETELY UNBIND THE VIEW
		this.undelegateEvents();
	
		$(this.el).removeData().unbind(); 
	
		//Remove view from DOM
		this.remove();  
		Backbone.View.prototype.remove.call(this);

    },
	
	
	//destroying the view....
	resetEntryValue : function(){
		$("#jecrc-subject-entry").val('');
		$("#jecrc-strength-entry").val('');
		//Resetting the buttons groups..
		$('.btn-group label,.btn-group button').removeClass('active');
		$("#jecrc-batch-entry").addClass("hide");
	},
	
	
	//Function for getting the entry on clicking of save button...
	getEntryValue:function(){
		//get subject value..
		var subject = $("#jecrc-subject-entry").val();
		if(subject === ''){
			this.displayMessage("Error: Subject cannot be empty.");
			console.log("subject cannot be empty..");
			return null;	
		}
		
		var lab = this.getLab();
		if(lab){
			batch = $("#jecrc-batch-entry input:checked").val();
			if(batch === undefined){
				this.displayMessage("Error: You must select a batch...");
				console.log("Batches cannot be empty..");
				return null;	
			}
		}
		else{
			batch = null;	
		}
		
		
		var period = this.getPeriod();
		if(period.length === 0){
			this.displayMessage("Error: You must select appropriate period.....");
			console.log("Error: You must select appropriate period.....");
			return null;	
		}
		
		var strength = $("#jecrc-strength-entry").val();
		if(strength === ''){
			this.displayMessage("Error: Strength cannot be empty.");
			console.log("Strength cannot be empty..");
			return null;	
		}
		
		var entryObj = {
			"subject_name"  :  subject,
			"lab"           :  lab,
			"period"        :  period,
			"strength"      :  strength,
			"faculty_id"    :  faculty["id"],
			"faculty_name"  :  this.FacultyName,
			"batch"         :  batch,
			"department_id" :  this["dept_id"],
			"semester_id"   :  this["semester_id"],
			"section_name"  :  this["section_name"],
			"days_entry_id" :  this.days_entry_id
				
		}
		
		//Now returning the entry object...
		return entryObj;
		
	},
	
	
	
	//Function for diplaying result and console screen...
	displayMessage : function(message){
		//Callback for success 
		$('#dept-info-box').removeClass('hide');
		$('#dept-info-box').html(message)
		setTimeout(function(){$('#dept-info-box').addClass('hide');}, 4000);
	}
		
	
});

//-------------------------VIEW FOR BRANCH---------------------------------
//View for Adding Branch...
app.Views.Branch = Backbone.View.extend({
	
	events:{
		"click a" : "unbindViewOnClick"
	},
	
	//UNBINDING EVENTS..
	unbindViewOnClick: function(){
		console.log("Unbinding branch view events..");
		this.undelegateEvents(); 
	},
	
	initialize: function(){
		//get the department name from model..
		if (this.collection.length === 0){
			console.log("returning from branch view initialize");
			return null;
		}
		var dept_id = this.collection.at(0).get("department_id");
		this.dept_name = app.Global.Department.findWhere({"id": dept_id}).get("name");
		this.year = ["I YEAR", "II YEAR", "III YEAR", "IV YEAR"];
		this.branchTemplate =  _.template( $("#branch-template").html() );	
		app.Global.dept = false;
	},
	
	el: $("#faculty-display-screen"),
	
		
	
	render: function(){
		
		//Cleaning el
		$(this.el).empty();
		
		if (this.collection.length === 0){
			return null;
		}
		
		
		var model_json = {};
		model_json.department = this.dept_name;
		model_json.years = [];
		var yearArray = [];
		var last = 0;
		for(var i = 0; i < 4; i++)
		{
			var temp = {}
			temp.branches = [];
			
			var sem = this.collection.where({"semester_id" : String(last+1)});
			//app.Global.x =  this.collection;
			
			
			if(sem !== undefined && !$.isEmptyObject(sem)){
				for(var j = 0 ; j<sem.length; j++){
					temp.branches.push(sem[j]);
				}
				
			}
			
			sem = this.collection.where({"semester_id" : String(last+1+1)});
			last = last +1 +1;
			if(sem !== undefined && !$.isEmptyObject(sem)){
				for(j = 0 ; j<sem.length; j++){
					temp.branches.push(sem[j]);
				}
			}
			
			app.Global.section_added = [];
			temp.branches = this.branchArray( temp.branches );
			//Adding year to yearArray..
			
			temp.yearname = this.year[i];
			//Now pushing values to year array..
			yearArray.push(temp);
		}
		model_json.years = yearArray;
		
		
		//Inserting to el..
		 $(this.el).html( this.branchTemplate( model_json ) );
		 
		return this;	
	},



	branchArray: function(branchesArray){
		var branch_array = [];
		for(var i=0 ; i < branchesArray.length; i++){
			
			var branch = {};
			var branchModel = branchesArray[i];
			
			//console.log(branchModel.get("id"));
			var id = branchModel.get("id");
			var semester_id = branchModel.get("semester_id");
			var section_name = branchModel.get("section_name");
			var batch_id =  branchModel.get("batch_id");
			branch.id = id;
			var name = semester_id + ' - '+ this.dept_name +' - '+ section_name ;
			//pushinf only if value is not present alreadt..
			if(app.Global.section_added.indexOf(name) === -1 )
			{
				//Now pushing this name to array...
				app.Global.section_added.push(name);
				branch.name = name;
				//now push to branches array
				branch_array.push(branch);
			}
		}
		return branch_array;
	}
	
	

});



app.Global.alertType = ["alert-danger", "alert-success", "alert-info", "alert-warning"];

//function for getting random numbers...
app.Global.randomNumber = function(min, max) {
  	return parseInt(Math.random() * (max - min) + min);
}

var getYear = function(id){
	var x = {
		1:"I YEAR",
		2:"I YEAR",
		3:"II YEAR",
		4:"II YEAR",
		5:"III YEAR",
		6:"III YEAR",
		7:"IV YEAR",
		8:"IV YEAR"	
	}
	return x.id;
}


var parseBranch = function(branchName){
	var patt = /([0-9])\s*\-\s*([a-zA-Z]+)\s*\-\s*([a-zA-Z])/
	var value = patt.exec(	branchName );
	value = value.splice(1);
	return value;
}

var parseDate = function(date){
	var patt = /([0-9]+)\s*\-\s*([0-9]+)\s*\-\s*([0-9]+)/
	var value = patt.exec(	date );
	value = value.splice(1);
	return value;
}

var getMonth = function(month){
	var x = {
		1:"January",
		2:"Fabuary",
		3:"March",
		4:"April",
		5:"May",
		6:"June",
		7:"July",
		8:"August",
		9:"September",
		10:"October",
		11:"November",
		12:"December"	
	}
	return x[month];
}

var convertDate = function(date){
	var par_date = parseDate(date);
	return getMonth(par_date[1]) + " " + par_date[2]; 	
}

var getInitialFacultyName = function(name){
	var patt = /([a-zA-Z])[a-zA-Z]*\s*([a-zA-Z])[a-zA-Z]*\s*/
	var value = patt.exec(	name );
	if(value){
		value = value.splice(1);
		return value[0].toUpperCase() + "." + value[1].toUpperCase();
	}
	
}

var getDay = function(sqlDateString){
	var d = new Date(sqlDateString);
	var day = d.getDay();
	var days = {
		1:"Monday",
		2:"Tuesday",
		3:"Wednesday",
		4:"Thursday",
		5:"Friday",
		6:"Saturday",
		7:"Sunday",	
	}
	return days[day];	
}//End of getday function..


//Get sql format of date ..
var getSqlDate = function(year, month, day){
		return year + "-" + month +"-"+ day;
}

var getTodayDate = function(){
	var d = new Date();
	var date  = d.getDate();
	//JAvascript month 0-11
	var month = d.getMonth();
	//converting to sql format month 1-12
	month=month+1;
	var year  = d.getFullYear();
	return getSqlDate(year, month, date);	
}










