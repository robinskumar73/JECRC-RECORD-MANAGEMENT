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
				app.Global.Branch.create(
					{
						"department_id":dept.get("id"),
						"semester_id":sem,
						"section_name":section,
						"batch_id":val 
					},
					{
						error: function (model, response) 
						{
							displayMessage('Error saving Branch..');
							$("#Dept-Cancel").click();
    					},
						success: function(model)
						{
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
					}
				);
			}
	});//End of each function..
	
});

//------------------------VIEW FOR DISPLAYING PERIOD ENTRY-----------------
app.Views.periodEntry = Backbone.View.extend({
	
	tagName:"div",
	
	className: "col-md-12",
	
	
	initialize:function(){
		//Adding the current view element...
		app.Global.Router.currentView  = this;
		//add the child views to this array...
		this.childViews = [];
		if (this.collection.length === 0){
			var name      = faculty.first_name + " " + faculty.last_name; 
			this.name     = getInitialFacultyName(name);
			var date      = getTodayDate();
			this.day      = getDay(date);
			this.date     = convertDate(date);
			this.template =  _.template( $("#faculty-table-data").html() );
			this.template = this.template({"day":this.day, "date": this.date, "faculty": this.name});
		}
		else
		{
			//For checking the lab table..
			this.lab = {	
				row0:null,
				row1:null,
				row2:null
			};
			/*{period:[], lab:{}, id=[]  } */
			//For storing lab period information..
			this.LabPeriodAdd = [];
			
			this.periodList   = $("<tr/>");
			this.subjectList  = $("<tr/>");
			this.strengthList = $("<tr/>");
			this.teacherList  = $("<tr/>");
			
			//Inserting date
			this.date             =  this.collection[0].get("date");
			
			this.department_name  =  app.Global.Department.findWhere({ "id":this.collection[0].get("department_id") }).get("name");
			this.section_name     =  this.collection[0].get("section_name");
			this.semester_id      =  this.collection[0].get("semester_id");
			this.day              =  getDay(this.date);
			this.parse_date	      =	convertDate(this.date);
		}
		
	},//End of initialize function..
	
	
	render:function(){
		$(this.el).empty();
		
		if (this.collection.length === 0){
				this.$el.append(this.template);
				return this;
		}
		
		
		//inserting period data..
		//this.addToList(this.collection);
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
		
		//populating table data..
		this.addToList(this.collection);
		
		this.table.append(body_);
		return this;	
	},
	
	addBody: function(day, date){
		
		//Adding department..
		this.$el.append( "<h4 class='report-dept-info'>" + this.semester_id + " " + this.department_name  + "</h4>");
		this.$el.append( "<span class='report-dept-info'>" + this.section_name + "</span><hr class='report-dept-info' style='margin-top:0px;margin-bottom:0px;'>");
		
		//Adding day..
		this.$el.append( "<h4 class='log_day'>" + day + "</h4>");
		this.$el.append( "<span class='log_date'>" + date + "</span>");	
		var div1   = $("<div class='col-md-12 jecrc-stats' />");
		var div2   = $("<div class='table-responsive'/>");	
		this.table = $("<table class='table table-striped'/>");
		div1.append(div2);
		div2.append(this.table);		
		this.$el.append( div1 );
		this.$el.append( "<br />" );
		
	},
	
	//Adding data to the list...
	addToList: function(modelArray){
		for(var i=0; i<modelArray.length; i++){
			var periodModel = modelArray[i];
			
			
			if(periodModel.get("lab") === "0")
			{
				   //console.log("I am inside if lab= false..");				
				  //Adding period
				  //Insert lab period..
				  for(var j = 0; j<periodModel.get("period").length; j++)
				  {
					  //Adding period...
					  this.periodList.append("<th>" + periodModel.get("period")[j] + "</th>");
				  }//End of for loop of entering period..
				  
				  var periodLen   = periodModel.get("period").length;
				  
				  //this.periodList.append("<th>" + periodModel.get("period")[0] + "</th>");
				  
				  //Adding subject..
				  this.subjectList.append("<td colspan='" +periodLen + "' >" + periodModel.get("subject_name") + "</td>");
				  //Adding subject list..
				  this.strengthList.append("<td  colspan='" +periodLen + "' >" + periodModel.get("strength") + "</td>");
				  //adding teacher list..
				  this.teacherList.append( "<td class='faculty_name_tuple' data-toggle='tooltip' data-placement='top' title='Faculty :  " +  periodModel.get("faculty_name").toUpperCase() + "' colspan='" +periodLen + "' >" + getInitialFacultyName( periodModel.get("faculty_name") ) + "</td>" );
			}
			else
			{
				
				  var currentLab = null;
				  var currentId  = [];
				  //First check for lab period..
			      /*{period:[], lab:{}, id=[]  } */
			      for(var x = 0; x < this.LabPeriodAdd.length; x++ )
			      {
						var lab_        = this.LabPeriodAdd[x].lab;
						var period_     = this.LabPeriodAdd[x].period;
						//Now matching period with current given period in the model..
						var givenPeriod = periodModel.get("period");
						//Now matching both period..
						if ($(period_).not(givenPeriod).length == 0 && $(givenPeriod).not(period_).length == 0 )
						{
							//current lab value 
							currentLab = lab_;
							currentId  = this.LabPeriodAdd[x].id;
							break;	
						}
				
				   }
				   
				   //Now inserting values of current lab value is null...
				   if (currentLab === null){
						//Insert value to initialize this current period..
						var lab_        = {	row0:null, row1:null, row2:null };
						var period_     = periodModel.get("period");
						//Adding to LabPeriodAdd object
						//Now updating the currentLab value..
						currentLab = lab_;
						//Now setting an random ids to lab elements for fetching..
						var id0 = app.Global.randomNumber(999,999999);
						var id1 = app.Global.randomNumber(999,999999);
						var id2 = app.Global.randomNumber(999,999999);
						
						currentId = [id0, id1, id2];
						
						this.LabPeriodAdd.push({ "period":period_, "lab": lab_, "id": currentId });
					   
				   }
				   
				  
				  
				
				  if(currentLab["row0"] === null)
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
				  if(currentLab["row0"] === null)
				  {	
		
					  row="0";
					   //Adding lab entry..
				  	  this.subjectList.append("<td id='"+ currentId[0] +"'  colspan='" +periodLen + "'  rowspan='" + row + "'  >" + subject + " -  "+section + batch + " Batch  -" + strength + " - " + facultyName + "</td>" );
					 
					  //Appending dummy list
					   this.strengthList.append("<td id='"+ currentId[1] +"'  colspan='" +periodLen + "'  rowspan='" + "1" + "'  >" + " -------  " + "</td>" );
					   this.teacherList.append("<td  id='"+ currentId[2] +"'  colspan='" +periodLen + "'  rowspan='" + "2" + "'  >" + " ------- " + "</td>" );
					   
					  //Setting up flags..
					  currentLab["row0"] = true;
					  
				  }
				  else if (currentLab["row1"] === null  )
				  {
					  
					  var element = this.strengthList.find("td#" + currentId[1]);
					  $(element).html(subject + " -  "+section + batch + " Batch  -" + strength + " - " + facultyName);
					  row="1";
					 
					  currentLab["row1"] = true;
				  }
				  else
				  {
					 
					  row="2";
					  //Finding element..
					  var element = this.teacherList.find("td#" + currentId[2]);
					  $(element).html(subject + " -  "+section + batch + " Batch  -" + strength + " - " + facultyName);
					  
					  currentLab["row2"] = true;
					  //reset stats..
					  currentLab["row0"] = null;
					  currentLab["row1"] = null;
					  currentLab["row2"] = null;
				  }
				  
				 
					  
			}//End of if-else..
		}//End of for loop..
	}//AddtoList function ends..
	

});


//-------------------------VIEW FOR FACULTY ENTRY--------------------------
app.Views.FacultyEntry = Backbone.View.extend({
	
	//el:$("#faculty-entry-record"),
	
	initialize: function(){
		console.log("inside app.Views.FacultyEntry constructor");
		
		$(this.el).empty();
		app.period = this.model;
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
		console.log("getting out app.Views.FacultyEntry constructor");
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
		console.log("app.Views.FacultyEntry view rendering");
		$(this.el).empty();
		//Appending the form to the el element...
		$(this.el).append(this.form);
		//Adding the autocomplete function...
		//Finding the element..
		var subjectEntry = $(this.$el).find( "#jecrc-subject-entry" );
		this.autoSelect = customSubjectSelectize( subjectEntry );
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
	
	
	
	//Only used for updating the entry form...
	//setting value if already present in the model...
	setValue : function( ){
		
		//Hiding the save and cancel buttons...
		var saveBtn    = this.$el.find("#faculty_save_button");
		var cancelBtn  = this.$el.find("#faculty_reset_button");
		//Detaching both the buttons...
		$(saveBtn).remove();
		$(cancelBtn).remove();
		
		//Removing the boreders....
		var containerElement = this.$el.find(".jecrc-stats");
		$(containerElement).removeClass('jecrc-stats');
		
		if( this.model.get("subject_name") ){
			//Adding the subject firsts..
			var control = this.autoSelect[0].selectize;	
			control.addOption({
				id:null,
				subject:this.model.get("subject_name")
			});
			//adding to the input field...
			control.addItem( this.model.get("subject_name") );
		}
		
		
		if( parseInt(this.model.get("lab")) === 1  ){
			//Select the lab button...
			var labLabelElement = this.$el.find("#lab-label");
			$(labLabelElement).addClass('active');
			var labElement = this.$el.find("#lab");
			
			$( labElement ).attr('checked', 'checked');
			//Adding the batch field...
			var batchElement = this.$el.find("#jecrc-batch-entry input");
			var batchContainer = this.$el.find("#jecrc-batch-entry");
			$(batchContainer).removeClass('hide');
			var that = this;
			$(batchElement).each(function(j, btn){
   				if( $(btn).val() === that.model.get("batch") )
				{
					//Add checked attr to this button...
					$(btn).attr('checked', 'checked');
					//Add active class to its parent properties...
					$( $(btn).parent() ).addClass('active');
				}
			})
			
		}
		else{	
			//Select the lab button...
			var classLabelElement = this.$el.find("#class-label");
			$(classLabelElement).addClass('active');
			var classElement = this.$el.find("#class");
			$(classElement).click();
			$( classElement ).attr('checked', 'checked');
		}
		
		
		var period = this.model.get("period");
		//Find the period element...
		var periodElement = this.$el.find(".dept-check");
		if(period.length){
			for(var i = 0; i<period.length; i++)
			{
			  $(periodElement).each(function(j, btn){
				  if( $(btn).data('wat') === parseInt( period[i]) ){
					  $(btn).addClass('active');
				  }	
			  });//end of each loop..
			}//end of for loop...
		}//End of if statement..
		
		//Adding the strength to the entry form...
		var strengthElement = this.$el.find("#jecrc-strength-entry");
		$(strengthElement).val( this.model.get("strength") );
		
	},//End of save function...



	saveEntry : function(){
		console.log("Inside save entry method!");
		var EntryValue = this.getEntryValue();
		if (EntryValue === null){
			return null;	
		}
		else{
			//Updating the url value for post operation..
			var that = this;
			
			if( parseInt(this.update) === 0  ){
				console.log('Saving the entry!');
				//Creating period entry model...
				var PeriodModel = new app.Model.periodEntry;
				//Adding an error validation event listener to it..
				//Listening to error events..
				this.listenTo(PeriodModel, 'invalid', this.validationFailed);
				//PeriodModel.url = "department.php/entry/department/daysEntry";
				PeriodModel.save(EntryValue,{
					error: function () {
						//that.displayMessage('Error saving Entry..');
						that.displayMessage("<strong>Error:</strong> saving entry.", app.Global.alertType[0]);
					},
					success: function(){
						//Undelecating the events..
						that.undelegateEvents();
						
						that.displayMessage("<strong>Successfully</strong> saved entry to database.", app.Global.alertType[1]);
						
						//NOW display Batches.. of department..
						fetchBranch(that.model.get("department_name"));
						//UPdating the URL..
						app.Global.Router.navigate('department/' + that["dept_name"],{trigger:true});
						//Removing the view..
						that.destroy_view();
						
					}
				});
			}//End of if for checking the this.update
			else{
				console.log("Updating the data.");
				//Getting the interface of facultylog collection
				var facultyLogId      = that.FacultyLogModel.get("id");
				that.FacultyLogModel  = app.Global.entryLogCollection.get( facultyLogId );
				this.model.save(EntryValue,{
					 headers:{
								//Sending the faculty headers with headers..
							 	faculty_id     : this.model.get('faculty_id'),
								"facultyLogId" : facultyLogId
							 },
					error: function ( model, response, options ) {
						//update faculty log model with error type update..
						//getting the date...
						that.undelegateEvents();
						var d = new Date();
						var time = d.getTime();
						
						that.FacultyLogModel.save(
						{
							 last_update_type: 'error',
							 last_updated_time: time 
						},
						{
							headers:
							{
								 //Sending the faculty headers with headers..
							 	faculty_id:that.model.get('faculty_id'),
							},
							success:function(){
								console.log("Successfully updated faculty entry to server.");
							},
							error:function(){
								console.log("Error updating faculty entry to server.");
							}
						});//End of save 
						//Removing the view..
						that.destroy_view();
						
					},
					success: function( model, response, options ){
						//Undelecating the events..
						//that.undelegateEvents();
						var log = response.log;
						var facultyLogId      = log.id;
						var logModel = app.Global.entryLogCollection.get( facultyLogId );
						//Updating the model..
						logModel.set(log);
						
						//getting the date...
						var d = new Date();
						var time = d.getTime();
						//Use entry_type = "error" to avoid error of rendering two icons set
						that.FacultyLogModel.set(
						{
							 last_update_type	: 'delete',
							 last_updated_time	: time,
							 entry_type			: "update",
							 sub_info		    : EntryValue.subject_name
							 
						}
						);
						//Removing the view..
						that.destroy_view();
					}
				});
			}//End of else of update statement
		}
		
		
	},
	
	//destroying the view..
	destroy_view: function() {
		//COMPLETELY UNBIND THE VIEW
		this.undelegateEvents();
	
		$(this.el).removeData().unbind(); 
	
		//Remove view from DOM
		this.remove();  
		Backbone.View.prototype.remove.call(this);

    },
	
	
	
	//Method if model validation fails..
	validationFailed: function(model){
		this.displayMessage(model.validationError, app.Global.alertType[3]);
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
			this.displayMessage("<strong>Error:</strong> Subject cannot be empty.",  app.Global.alertType[3]);
			return null;	
		}
		
		var lab = this.getLab();
		if(lab){
			batch = $("#jecrc-batch-entry input:checked").val();
			if(batch === undefined){
				this.displayMessage("<strong>Error:</strong> You must select a Batch.", app.Global.alertType[3]);
				return null;	
			}
		}
		else{
			batch = null;	
		}
		
		
		var period = this.getPeriod();
		if(period.length === 0){
			this.displayMessage("<strong>Error:</strong> You must select atleast 1 Period.", app.Global.alertType[3]);
			return null;	
		}
		
		var strength = $("#jecrc-strength-entry").val();
		if(strength === ''){
			//Displaying message with alert type danger..
			this.displayMessage("<strong>Error:</strong> Strength cannot be empty.", app.Global.alertType[3]);
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
	displayMessage : function(message, type){
		var Template = _.template( $("#display-info").html() );
		this.display =  Template( {"message": message, "typeInfo": type } );
		//Callback for success 
		//Now adding this info to form display ..
		$("#dept-info-box").html(this.display);
		//setTimeout(function(){$('.alert').alert('close');}, 5000);
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
		//Setting the current view for deleting of the memory leaks...
		app.Global.Router.currentView = this;
		
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
		console.log("Inserting to branch el html element..");
		
		$(this.$el).html( this.branchTemplate( model_json ) );
		 
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




//--------------------------------------------VIEW FOR FACULTY ALERT MESSAGE BOX--------------------------------------
//Takes 2 argument as option - 1) model:model_for_faculty_log_entry 2) delete:0 or 1 if true then delete button was clicked..
app.Views.logAlertBox = Backbone.View.extend({
	initialize: function(){
		
		//add the child views to this array...
		this.childViews = [];
		
		//Cache the template function for displaying the alert box..
		this.template	= _.template( $('#display-info').html() );
		//Listening to facultyLogModel for change...
		this.listenTo(this.model, 'change:last_updated_time', this.destroy_view);
	},
	
	events:{
		'click #entry-action-btn' 			: 'deleteItem',
		'close.bs.alert #dept-display-box'	: 'removeView'
	},
	
	
	
	
	//Event when a view a removed...
	removeView: function(){
		var d = new Date();
		var time = d.getTime();
		this.model.set({
		  last_update_type: 'error',
		  last_updated_time: time
		});
	},
	
	
	
	//Event when delete button is pressed and then confirmed to delete..
	deleteItem: function(){
		if( this.model.get('entry_type') === 'entry' || this.model.get('entry_type') === 'update' )
		{
			var that = this;
			//Fetch the period entry model...
			var periodEntry = new app.Model.periodEntry({ "id": this.model.get('info_entry_id') });
			//Now send delete request to the server the periodEntry Model
			periodEntry.destroy({ 
				headers:{
					"faculty_id"   : 	that.model.get('faculty_id'),
					"facultyLogId" :    that.model.get("id")
				},
				success: function( model, response, options ){
					console.log("Successfully deleted period entry from server!");
					var message = "Successfully deleted period entry from server!";
					//update the activity log...
					var logEntry = app.Global.entryLogCollection.get(response.id);
					if(logEntry === undefined)
					{
						logEntry.add(response);
					}
					else{
						logEntry.set(response);
					}
					//Updating the log.
					//Undelecating the events..
					that.displayMessage(message, that, app.Global.alertType[1]);
					/*
					that.undelegateEvents();
					//getting the date...
					var d = new Date();
					var time = d.getTime();
					that.model.save({
						 last_update_type: 'delete',
						 last_updated_time: time,
						 headers:{
							 //Sending the faculty headers with headers..
							faculty_id : that.model.get('faculty_id'),
						 }, 
					});
					//Removing the view..
					//that.destroy_view();
					*/
				},
				error: function( model, response, options ){
					console.log("Error deleting period entry from server!");
					var message = "Error deleting subject entry from server!";
					
					//Updating the log.
					//Undelecating the events..
					that.displayMessage(message, that, app.Global.alertType[3]);
					/*
					that.undelegateEvents();
					//getting the date...
					var d = new Date();
					var time = d.getTime();
					that.model.save({
						 last_update_type: 'error',
						 last_updated_time: time,
						 headers:{
							 //Sending the faculty headers with headers..
							faculty_id : that.model.get('faculty_id'),
						 }, 
					});
					*/	
				}
			});//END OF periodEntry.destroy
		}
		else if(  this.model.get('entry_type') === "subject" ){
			var that = this;
			//Fetch the period entry model...
			var subjectEntry = new app.Model.Subject({ "id": this.model.get('info_entry_id') });
			//Now send delete request to the server the subjectEntry Model
			//Now send delete request to the server the periodEntry Model
			subjectEntry.destroy({ 
				headers:{
					"faculty_id" : 	that.model.get('faculty_id'),
					//Adding faculty log id..
					"facultyLogId" : this.model.get("id")
				},
				success: function(){
					console.log("Successfully deleted subject entry from server!");
					var message = "Successfully deleted subject entry from server!";
					//Updating the log.
					//Undelecating the events..
					that.displayMessage(message, that, app.Global.alertType[1]);
					//that.undelegateEvents();
					//getting the date...
					//var d = new Date();
					//var time = d.getTime();
					/*
					that.model.save({
						 last_update_type: 'delete',
						 last_updated_time: time,
						 headers:{
							 //Sending the faculty headers with headers..
							faculty_id : that.model.get('faculty_id'),
						 }, 
					});
					*/
					//Removing the view..
					//that.destroy_view();
					
				},
				error: function( model, response, options ){
					console.log("Error deleting subject entry from server!");
					//"errorCode": "#0000"
					var message = "<strong>Subject cannot be deleted</strong> . You can only <strong>rename</strong> the subject until all its related subject enteries are deleted.";

					//Updating the log.
					//Undelecating the events..
					that.displayMessage(message, that, app.Global.alertType[3]);
					//that.undelegateEvents();
					//getting the date...
					//var d = new Date();
					//var time = d.getTime();
					/*
					that.model.save({
						 last_update_type: 'error',
						 last_updated_time: time,
						 headers:{
							//Sending the faculty headers with headers..
							faculty_id : that.model.get('faculty_id')
						 }, 
					});
					*/
						
				}
			});//END OF subjectEntry.destroy
			
		}
		else{
			/* do nothing*/
		}
	},//END OF deleteItem method
	
	
	
	//For displaying of message on delete...
	displayMessage : function(message, context, alert_type){
		//Callback for success 
		var parentBox = context.$el.find("#dept-display-box");
		var alertBody = context.$el.find(".delete-info");
		for(var i=0; i< app.Global.alertType.length; i++)
		{
			$(parentBox).removeClass(app.Global.alertType[i]);
		}
		$(parentBox).addClass(alert_type);
		$(alertBody).empty();
		$(alertBody).html(message);
		//Now destroying this view after3 second..
		//setTimeout(function(){ context.destroy_view() }, 3000);
	},
	
	
	//Function for rendering the logAlertBox...
	render:function(){
		//app.Views.alertBod
		if( parseInt(this.delete) === 1 )
		{
			//Delete button was clicked ...
			//Get the alert box modal..
			var deleteTemplateBox     = _.template( $("#display-info").html() );
			var deleteAlertBody	      = _.template( $("#entry-log-alert-body").html() );	
			deleteAlertBodyElement    = deleteAlertBody();
			deleteTemplateBoxElement  = deleteTemplateBox({ "message" : deleteAlertBodyElement, "typeInfo": app.Global.alertType[0] });
			//Appending this to el element..
			this.$el.append( deleteTemplateBoxElement );
			
		}
		else{
			//Edit button was clicked...
			//Create an instance of alertBody view...
			var alertBody = new app.Views.alertBody({ model: this.model });
			
			//adding the child view...
			this.childViews.push(alertBody);
			
			//appending this alertBody Content to el element...
			this.$el.append(alertBody.el);  
		}
		
		return this;
		
	},
	
	//view destructor...
	//destroying the view..
	destroy_view: function() {
		//COMPLETELY UNBIND THE VIEW
		console.info("Destroying the modal display 'logAlertBox' view.  ")
		this.undelegateEvents();
		$(this.el).removeData().unbind(); 
		//Remove view from DOM
		this.remove();  
		Backbone.View.prototype.remove.call(this);
	}		
});



//------------------------------------------VIEW FOR SHOWING THE MESSAGE FOR ALERT-------------------------------------
//Takes one argument model of faculty log entry...
app.Views.alertBody = Backbone.View.extend({
	initialize : function(){
		
		//add the child views to this array...
		this.childViews = [];
		
		this.template =  _.template( $('#alert-modal').html() );
		//Append this template to el element...
		this.$el.append( this.template() );
		
		//alert-modal
		if( this.model.get('entry_type') === 'entry' || this.model.get('entry_type') === 'update' ){
			if(this.model.get('last_update_type') !== 'delete')
			{	
				//Creating a model for fetching an period of given id;
				this.periodModel 	=  new app.Model.periodEntry({ id: this.model.get('info_entry_id') });
				
				this.listenTo(this.model, 'change:last_updated_time', this.removeView);
				
				this.fetchEntryModel(this.periodModel);
			}
		}
		//Updating the subject name
		else if( this.model.get('entry_type') === 'subject' && this.model.get('last_update_type') !== 'delete' ){
			//Show the subject edit for update..
			this.subjectModel 	=  new app.Model.Subject( { "id":this.model.get('info_entry_id'), "subject":this.model.get('sub_info')} );				
			//Now show modal showing subject update...
			this.showSubjectModal(this.subjectModel);
		}
		else{
			/*Do nothing */
			console.log("Wrong Entry type");
			return false;
		}
		
	},//End of initialize function ...
	
	
	events:{
		//'click #alert_modal_close_btn' : 'closeModal',
		'click #alert_modal_save_btn'  : 'saveModal',
		'hide.bs.modal #myModal'	   : 'removeView',
		//When modal is loaded...
		'shown.bs.modal #myModal'	   : 'addAutoComplete'
		
	},
	
	showSubjectModal: function(subjectModel){
		//Forming the model...
		var heading = "Edit subject!";
		//First showing an input box with..value as subject value..
		var body    = '<input type="text" id="jecrc-subject-entry-update" class="form-control jecrc-dept-entry" placeholder="Subject Name">';
		//this.subjectTemplateView = this.template({"heading":heading, "body":body});
		//Adding the heading and body to the modal...
		var headingElement  = this.$el.find('#myModalLabel');
		var bodyElement		= this.$el.find('.modal-body');
		//Appending data to this element respectively....
		$(headingElement).append(heading);
		$(bodyElement).append(body);		
	},
	
	
	
	//Adding autocomplete option to the subject input form..
	addAutoComplete: function()
	{
		if( this.model.get('entry_type') === 'subject' && this.model.get('last_update_type') !== 'delete' ){
			//Finding the input element
			var inputElement = this.$el.find("#jecrc-subject-entry-update");
			var select_ = customSubjectSelectize( $( inputElement ) );
			//Getting the selectize instance...
			var control = select_[0].selectize;
			//Now adding data to the input element..
			control.addOption( this.subjectModel.toJSON() );
			control.addItem( this.subjectModel.get('subject') );
		}
	},
	
	
	//Method for forming the entry body and appending to $el element on model change event...
	addPeriodEntryBody : function( periodModel ){
		//Removing period of myModal
		heading	= this.$el.find('.modal-footer');
		$(heading).addClass('modal-form');
		
		var department_name = this.getDepartmentName(periodModel);
		periodModel.set({"department_name" : department_name});
		var Periodcollection = new app.Collection.periodEntry( periodModel );
		this.facultyEntry = new app.Views.FacultyEntry({
			model		    : periodModel,				
			collection      : Periodcollection
		});
		//Addding the params...
		this.facultyEntry.update 			= 1;
		this.facultyEntry.FacultyLogModel   = this.model;
		
		//add the child views to this array...
		this.childViews.push( this.facultyEntry );
		
		//Rendering the faculty...
		this.facultyEntry.render();
		//Setting the initial values...
		this.facultyEntry.setValue();
		//Adding to the el
		//Adding this  body to faculty
		var heading =  "Edit your entry!";
		
		var headingElement  = this.$el.find('#myModalLabel');
		var bodyElement		= this.$el.find('.modal-body');
		//Appending data to this element respectively....
		$(headingElement).append( heading );
		$(bodyElement).append( this.facultyEntry.el );		
	},
	
	
	
	//Rendering the view...
	render: function(){
		return this;
	},
	
	
	
	//event when modal is about to close...
	removeView: function(){
		console.log('Modal is going to hide.Destroying the views.');
		//First destroying the faculty update entry view...
		if( this.facultyEntry !== undefined )
		{
			//destroy this view
			this.facultyEntry.destroy_view();	
		}
		//Now finally destroying this view...
		this.destroy_view();	
	},
	
	
	
	
	//Event when save entry button is pressed...
	saveModal: function(e){
		
		if( this.model.get('entry_type') === 'entry' || this.model.get('entry_type') === 'update' ){
			console.info('Saving the updated the entry data...');
			this.facultyEntry.saveEntry();
		}
		//IF MODEL VIEWING IS SUBJECT UPDATE...
		if( this.model.get('entry_type') === 'subject'){
			console.info('Saving the updated subject..');
			//NOW FETCHING THE DATA...
			//Find the element..
			var inputElement = this.$el.find("#jecrc-subject-entry-update");
			var subject		 = $(inputElement).val();
			var that = this;
			if( subject ){
				var oldSubjetName = this.subjectModel.get("subject");
				this.subjectModel.save({ "subject": subject },
				{
					headers:{
						"faculty_id"   : that.model.get('faculty_id'),
						"Oldsubject"   : oldSubjetName,
						//Adding faculty log id..
						"facultyLogId" : that.model.get("id")
					},
					success:function(Model)
					{
						console.log("Successfully updated subject!");
						//Undelecating the events..
						that.undelegateEvents();
						//Adding the log to the log collection...
						//Model.log contains the json of updated log model
						var logModel = app.Global.entryLogCollection.get(Model.get("log").id);
						//updating the changed log to the model..
						logModel.set( Model.get("log") ); 
						//getting the date...
						var d = new Date();
						var time = d.getTime();
						that.model.save(
						{
							 last_update_type: 'update',
							 last_updated_time: time,
						},
						{
							 headers:
							 {
								 //Sending the faculty headers with headers..
								faculty_id : that.model.get('faculty_id'),
							 },	
							 error:function(){
								console.log("Error updating faculty log to server"); 
							 },
							 success:function(Model){
								console.log("Successfully updated faculty log to server");
								
							 }
						});
						//Removing the view..
						//that.removeView();
					},
					error:function()
					{
						console.log("Error updating the subject to server!");
						//Undelecating the events..
						that.undelegateEvents();
						//getting the date...
						var d = new Date();
						var time = d.getTime();
						that.model.save(
						{
							 last_update_type: 'error',
							 last_updated_time: time, 
						},
						{
							 headers:
							 {
								 //Sending the faculty headers with headers..
								faculty_id : that.model.get('faculty_id'),
							 },	
							 error:function(){
								console.log("Error updating faculty log to server"); 
							 },
							 success:function(){
								console.log("Successfully updated faculty log to server"); 
							 }
						}
						
						);
						//Removing the view..
						//that.removeView();
					}//end of error function
				}//End of option object
				);	//End of save function..
			}//End of if of subject...
		}
		//Now hiding the modal..
		$(this.$el.find('#myModal')).modal('hide');
	},
	
	
	
	
	getDepartmentName: function(PeriodModel){
		//Now fetching the department name...
		var dept_model     = app.Global.Department.findWhere({ "id": PeriodModel.get("department_id") });
		var dept_name 	   = dept_model.get('name'); 
		var department     = PeriodModel.get("semester_id") + dept_name + '-' + PeriodModel.get("section_name");
		return department;
	},
	
	
	//Model for fetching the entry from the database...
	fetchEntryModel: function( Periodmodel ){
		var that = this;
		//Showing the loading bar...
		app.Global.showLoadingBar();
		//model.url = fetchUrl;
		Periodmodel.fetch({
			//Adding an error callback...
			error: function( model, response, options ){
				//Hiding the loading bar....
				app.Global.hideLoadingBar();
				console.log("Error fetching  period_entry collection from server...");	
			},
			success: function( model, response, options ){
				//Hiding the loading bar...
				app.Global.hideLoadingBar();
				console.log("Successfully fetched data of period_entry from server.");
				that.addPeriodEntryBody(Periodmodel);	
			}
		 });
	},
	
	
	//destroying the view..
	destroy_view: function() {
		//COMPLETELY UNBIND THE VIEW
		this.undelegateEvents();
		$(this.el).removeData().unbind(); 
		//Remove view from DOM
		this.remove();  
		var d = new Date();
		var time = d.getTime();
		//Now updating the model last update time...
		this.model.set({'last_updated_time':time,'last_update_type':'error'});
		Backbone.View.prototype.remove.call(this);
    }
});








//-----------------------------------------------View for FACULTY LOG ENTRY------------------------------------------

app.Views.faculty_entry = Backbone.View.extend({
	initialize:function(){
		//add the child views to this array...
		this.childViews = [];
		// Cache the template function for a single item.
    	this.template 				= _.template( $('#faculty_home_log').html() );
		this.listenTo( this.model, 'change:last_updated_time', this.alertBoxClosed );
		this.listenTo( this.model, 'change:info', this.render );
		//For storing the detach icons element...	
		this.detachIconsElement		= null;
		
	},
	
	
	//For destroying the related child views...
	beforeClose:function(){
		if(this.childViews){
		  var len = this.childViews.length;
		  for(var i=0; i<len; i++){
			  this.childViews[i].destroy_view();
		  }
		}//End of if statement
	}, //End of beforeClose function

	
	
	//... is a list tag.
    tagName:  "li",
	// The DOM events specific to an item..
    events: {
      "click a#log-entry-edit"     : "editEntry",
	  "click a#log-entry-delete"   : "deleteEntry",
    },
	
	// Re-render the titles of the todo item.
    render: function() {
      this.$el.html(this.template(this.model.toJSON()));
      return this;
    },
	
	//Trigger when  model property  last_update_time is changed
	alertBoxClosed : function(model, value, options){
		//Now checking the model update type property...
		if( ( model.get('last_update_type') === 'update' || model.get('last_update_type') === 'error')  && this.detachIconsElement !== null )
		{
			//update has been done on entry..
			//show the icons...
			var iconsContainer = this.$el.find("#log-icons-containers");
			$(iconsContainer).append( this.detachIconsElement );
		}
		
	},
	
	
	editEntry: function(e){
		e.preventDefault();
		//detach the icons.. and store it safe first...
		this.iconsElement 			= this.$el.find("#log-entry-edit, #log-entry-delete");
		this.detachIconsElement		= $(this.iconsElement).detach();
		console.log("Editing the entry..");
		//Now appending the data from the log-alert-action view..
		var alertBox = new app.Views.logAlertBox({ "model" : this.model });
		alertBox.delete = 0;
		
		//adding the child views...
		this.childViews.push(alertBox);
		
			
		//Now appending to el element..
		this.$el.append( alertBox.render().el );
		var modal = this.$el.find('#myModal');
		console.log('showing the modal window..');
		$(modal).modal('show');
	},
	
	
	
	deleteEntry: function(e){
		e.preventDefault();
		//detach the icons.. and store it safe first...
		this.iconsElement 			= this.$el.find("#log-entry-edit, #log-entry-delete");
		this.detachIconsElement		= $(this.iconsElement).detach();
		console.log("deleting the entry..");
		//Now appending the data from the log-alert-action view..	
		var alertBox = new app.Views.logAlertBox({ "model" : this.model });
		alertBox.delete = 1;
		
		//adding the child views...
		this.childViews.push(alertBox);
		
		//Now appending to el element..
		this.$el.append( alertBox.render().el );
	}
	
});





//Main app entry for the faculty page..
app.Views.activity = Backbone.View.extend({
	
	//Initializing the view...
	initialize: function(){
		//Setting the current views....
		app.Global.Router.currentView = this;
		//add the child views to this array...
		this.childViews = [];
		this.listenTo(this.collection, 'add', this.addOne);
		
		this.listenTo(this.collection, 'reset', this.addAll);
		this.offset = 0;
		this.limit  = 10;
		//{date:unorderedListelement}
		this.daysEntryRecord = {};
		//Now fetching from this collection and reset the collection after fecthing.....
		this.fetchMore();
		var that = this;
		//Adding window scroll option for infinite scroll options...
		$(window).scroll(_.debounce(function(){
   			if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
       			console.log("scroll position: near  bottom!");
				//Now fetch more collection on pagination options..
				that.fetchMore();
      		}
   		},300));
		
	},
	
	//Function for closing the child views for managing the memory leaks...
	beforeClose:function(){
		if(this.childViews){
		  var len = this.childViews.length;
		  for(var i=0; i<len; i++){
			  this.childViews[i].destroy_view();
		  }
		}//End of if statement
	}, //End of beforeClose function
	
	
	//Adding an function for fetching value from the 
	fetchMore:function(){
		var that = this;
		//showing the loading bar....
		app.Global.showLoadingBar();
		 
		this.collection.fetch({
			data: {offset: that.offset, limit:that.limit, faculty_id: faculty.id },
			remove:false,
			//Adding an error callback...
			error: function(collection, response, options){
				app.Global.hideLoadingBar();
				console.log("Error fetching collection from faculty_entry collection.");	
			},
			success: function(collection, response, options){
				app.Global.hideLoadingBar();
				console.log("Successfully fetched data of faculty_entry from server.");
				//Now updating  the offset..
				var length = response.length;
				that.offset = that.offset + length;	
			}
		 });
	},//End of fetch more function...
	
	//Adding the display element..
	//el: $("#faculty-display-screen"),
	
	//Handling when a logModel is added to the collection...
	addOne: function( logModel ){
		//getting a model date..
		var date      = logModel.get('date');
		var day       = getDay(date);
		var absDate   = convertDate(date);
		
		//Now checking if same date entry is present already.....
		if( this.daysEntryRecord[date] === undefined )
		{
			var parentElement 			= $('<div class="col-md-12 col-xs-12 "></div>');
			var dayElement	  			= $('<h4 class="log_day"></h4>');
			var dateElement   			= $('<span class="log_date"></span>');
			var UnorderedlistElement	= $('<ul class="jecrc-stats log"></ul>')
			//Append
			parentElement.append(dayElement);
			//Appending to parent
			//Appending the parent element to the document element...
			$(this.$el).append(parentElement);
			dayElement.append(day);
			parentElement.append(dateElement);
			dateElement.append(absDate);
			parentElement.append(UnorderedlistElement);
			//Adding entry..
			this.daysEntryRecord[date] = UnorderedlistElement;
				
		}
		//Now adding view to the entry...
		var EntryView = new app.Views.faculty_entry({model: logModel});
		//Now adding it to the childViews...
		this.childViews.push(EntryView);
		
		//Now loading the view finally...
		$(this.daysEntryRecord[date]).append( EntryView.render().el );
	},
	
	
	
	//Adding all models to the collection...
	addAll: function(){
		//Clearing the main element...
		//$(this.el).empty();
		console.log('resetting  the log entry view...');
		this.collection.each( this.addOne, this );
	},
	
	
	
	render: function(){
		//Clearing the main element...
		$(this.$el).empty();
		if(this.collection.length){
			this.addAll();
		}
		return this;
	}
	
	
});

//----------------------------------------------End of faculty home screen view------------------------

