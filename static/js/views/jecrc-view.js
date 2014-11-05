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
			//Adding to collapse nav bar..
			$("#collapse-nav-bar").append('<li class="jecrc-nav-hide"><a href="#department/' + app.Global.Department.at(i).get("name")  +  '"  >' + app.Global.Department.at(i).get("name") + '</a></li>');
			//collapse-nav-bar
			
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
		//Adding the current view element...
		app.Global.Router.currentView  = this;
		
		//Now fetching of data..
		this.fetchMore( this.collection );
		
		var that = this;
		//Adding the scrolling options for fetchin more enteries..
		//Adding window scroll option for infinite scroll options...
		$(window).scroll(_.debounce(function(){
   			if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
       			console.log("scroll position: near  bottom!");
				//Now fetch more collection on pagination options..
				that.fetchMore( that.collection );
      		}
   		},300));	
	},//End of initialize function..
	
	
	
	//Adding a function for fetching more items...
	fetchMore: function( Periodcollection ){
	   console.log("Inside fetch more function..");
	   var that    = this;
	   app.Global.showLoadingBar();
	  //Now fetching url..
	  Periodcollection.fetch({
		  
		  error: function ( collection, response, options ) {
			  
			  app.Global.hideLoadingBar();
			  console.log('Error fetching department wise entry from database..');
		  },
		  

		  success: function(collection, response, options){
			  //$("#jecrc-main-screen").html('');
			  console.log('Successfully fetched department wise entries data..');
			  //Getting the dates of entry in decreasing order..
			  var entry_arr  = $.unique(Periodcollection.pluck("days_entry_id"));
		  	 
			  for(var i=0; i<entry_arr.length; i++)
			  {
					  //finding the entry model one by one....
					  that.entry_model_arr = Periodcollection.where({ "days_entry_id" : entry_arr[i] });
					  //Processing the after fetch operations...
			  		  that.afterFetch( that.entry_model_arr );
					  //var periodView = new app.Views.periodEntry({collection:entry_model_arr});
					  //Appending the period entry to el..
					  $("#jecrc-main-screen").append( that.render().el );
			  }
			  
			  //Now updating  the offset..
			  var length = that.entry_model_arr.length;
			  that.collection.data.offset = that.collection.data.offset + length;
			  
			  app.Global.hideLoadingBar();
		  }, //End of success function....
		  
		  
		  "data": that.collection.data
		  
		});//End of period collection fetch
	},//End of fetchMore function...
	
	
	
	
	//Function for performing the operations after fetching of respective period entry data..
	afterFetch: function( collectionArray ){
		if ( collectionArray.length === 0 ){
				console.log("destroying the period entry view as zero data fetched from the server");
				this.destroy_view();
			}
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
			this.date            =  collectionArray[0].get("date");
			this.department_name =  app.Global.Department.findWhere({ "id":collectionArray[0].get("department_id") }).get("name");
			this.section_name    =  collectionArray[0].get("section_name");
			this.semester_id     =  collectionArray[0].get("semester_id");
			this.day             =  getDay(this.date);
			this.parse_date	     =	convertDate(this.date);	
	},//End of afterFetch function...
	
	
	
	
	render:function(){
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
		//inserting period data..
		this.addToList(this.entry_model_arr);
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
	
	el:$("#faculty-entry-record"),
	
	initialize: function(){
		//get the department name from model..
		
	
		this.dept_name    =  this.model.get("name");
		this.Template     =   _.template( $("#faculty-entry-form").html() );
		this.form 	      =  this.Template( {"department": this.dept_name} );
	},
	
	render:function(){
		$(this.el).empty();
		$(this.el).append(this.form);
		return this;	
	}
});

//-------------------------VIEW FOR BRANCH---------------------------------
//View for Adding Branch...
app.Views.Branch = Backbone.View.extend({
	
	initialize: function(){
		app.Global.Router.currentView  = this;
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








