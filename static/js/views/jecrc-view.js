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
		 headers:{
			//Sending the faculty headers with headers..
			faculty_id  : faculty.id,
		},	
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
				},
				 headers:{
					//Sending the faculty headers with headers..
					faculty_id  : faculty.id,
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
		$("#collapse-nav-bar").append('<li class="jecrc-nav-hide"><a href="#department/' + value  +  '"  >' + value	+ '</a></li>');
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
		//for containing the element data with dept wise...
		this.deptDataObj = {};
		
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
			  //First getting the entry department wise...
			  var deptObjUniqueArray = that.branchUniqueObject( Periodcollection );
			  
			  //For getting the dept wise entry...
			  for(var key in deptObjUniqueArray)
			  {   
					var deptObj           = deptObjUniqueArray[key];
					
					
					var department_id     = deptObj["department_id"];
					var semester_id       = deptObj["semester_id"];
					var section_name      = deptObj["section_name"];
					var department_name   = app.Global.Department.findWhere({ "id":department_id }).get("name");
					var entryArrDeptWise  =  Periodcollection.where( deptObj );
					
					
					//Now checking if same department is present on document body already in this case just append...
					if( that.deptDataObj[key] )
					{
						//Just collect a refrence of el element..
						that.$el = 	that.deptDataObj[key];
					}
					else{
						//Adding the department information ....
						that.$el.append( "<h4 class='report-dept-info'>" + semester_id + " " + department_name  + "</h4>");
						that.$el.append( "<span class='report-dept-info'>" + section_name + "</span><hr class='report-dept-info' style='margin-top:0px;margin-bottom:0px;'>");	
					}
					
					//Now creating a temp. collection for getting collection by date..
					var tempCollection    =  new app.Collection.periodEntry( entryArrDeptWise );
					
					//Now plucking days_entry_id from collection...
					var dateArr            =  tempCollection.pluck("days_entry_id");
					//Now getting the collection by date in decreasing order...
					var entry_arr  = _.uniq( dateArr , true);			
					   
					//Now sorting the entry array records based on days entry id..
					entry_arr = _.sortBy( entry_arr , function(num) {
						return num;
					}); 
					entry_arr = entry_arr.reverse(); 
					
					console.info("Printing the department wise entry arr");
					console.log(entry_arr);
					
					//Storing a refrence of the $el element...
					that.deptDataObj[key] = that.$el;
					
					
					for(var i=0; i<entry_arr.length; i++)
					{
						//finding the entry model one by one....
						that.entry_model_arr = Periodcollection.where({ "days_entry_id" : entry_arr[i] });
						//Processing the after fetch operations...
						that.afterFetch( that.entry_model_arr );
						//var periodView = new app.Views.periodEntry({collection:entry_model_arr});
						//Appending the period entry to el..
						$("#jecrc-main-screen").append( that.render().el );
						
					 }//End of For loop...
					
			  }
			  
			  //that.collection.data.offset = that.collection.data.offset + length;
			  that.collection.data.offset = parseInt(that.collection.data.offset)+ parseInt(that.collection.data.limit) ;
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
	
	
	
	
	branchUniqueObject : function( periodCollection )
	{
		var arrObj = {};
		periodCollection.each(function(model){
			var branchName =  model.get( "semester_id") + " - " + model.get("department_id") + " - " +  model.get( "section_name"); 
			//Forming the assosiative arrays...
			arrObj[ branchName ] = {
				semester_id   : model.get( "semester_id"),
				department_id : model.get("department_id"),
				section_name  : model.get( "section_name")
			}
		});
		return arrObj;
	},//end of arrayObject...
	
	
	
	
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
		/*
		//Adding department..
		this.$el.append( "<h4 class='report-dept-info'>" + this.semester_id + " " + this.department_name  + "</h4>");
		this.$el.append( "<span class='report-dept-info'>" + this.section_name + "</span><hr class='report-dept-info' style='margin-top:0px;margin-bottom:0px;'>");
		*/
		
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
		//Adding right side hook elements related to branch...
		this.childViews                = [];
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
		this.editButton = false;
	},
	
	
	events:{
		//"click #branch-remove-icon" : "removeBranch",
		//"click .branch-edit-icon"   : "showEditBranchIcons"
	},
	
	
	
	removeBranch:function(){
		
	},
	
	
	
	showEditBranchIcons: function(){
		if(!this.editButton)
		{
			//hide icons...
			$(".branch-remove-icons").removeClass('hide');	
			this.editButton = true;	
		}
		else{
			//hide icons...
			$(".branch-remove-icons").addClass('hide');	
			this.editButton = false;		
		}
		
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
		 
		 //Adding the add faculty template....
		 var facultyModel = new app.Model.Faculty;
		 facultyModel.set( "department_id", this.collection.at(0).get("department_id") );
		 var facultyView = new app.Views.CreateFaculty({ model:facultyModel });
		 facultyView["department_id"] = this.collection.at(0).get("department_id");
		 //add this view to the child views...
		 this.childViews.push( facultyView );
		 //Now rendering the create faculty template....
		 $("#right-side-hook").append( facultyView.render().el );
		 
		 
		 //Now adding the faculty list model ..
		 var facultyList_ = new app.Views.ShowFaculty;
		 facultyList_.department_id = this.collection.at(0).get("department_id");
		 facultyList_.fetchMore();
		 $("#right-side-hook").append( facultyList_.el );
		  //add this view to the child views...
		 this.childViews.push( facultyList_ );
		 
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
	},
	
	
	
	//Function for diplaying result and console screen...
	displayMessage : function(message, type){
		var Template = _.template( $("#display-info").html() );
		this.display =  Template( {"message": message, "typeInfo": type } );
		//Callback for success 
		//Now adding this info to form display ..
		var displayElement = this.$el.find("#display-info-box");
		$(displayElement).html(this.display);
	}

	
	

});



//-----------------------------------------------VIEWS FOR CREATING FACULTY---------------------------------------------------

//Accept a argument model of faculty...
//View for Creating Activity.....
//Provide department_id value rendering this..
//Child Views...
app.Views.CreateFaculty = Backbone.View.extend({
	
	initialize: function(){
		//initializing template for create faculty...
		this.template = _.template( $("#Create-Faculty-Template").html() );
		//For listening to validation error..
		this.listenTo(  this.model , 'invalid', this.validationFailed );
	},
	
	
	
	//For getting the value of faculty info 
	getValue: function(){
		var firstName     = $("#faculty-first-name").val();
		var lastName      = $("#faculty-last-name").val();
		var userName      = $("#faculty-user-name").val();
		var emailAddress  = $("#faculty-email-address").val();
		//check if values are empty...
		if( !firstName.length && !lastName.length && !userName.length && !emailAddress.length )
		{
			message = "All <strong>values</strong> must be entered.";
			//Display message showing all values not entered...
			this.displayMessage( message, app.Global.alertType[3] );
			return false;	
		}
		
		var Obj = {
			first_name   : firstName,	
			last_name    : lastName,
			username     : userName,
			email_address : emailAddress
		}
		//Return the object..
		return Obj;
	},
	
	
	
	//Event management...
	events:{
		"click  #faculty-create-btn"  : "saveEntry",
		"click  #faculty-reset-btn"   : "resetEntry"
	},
	
	
	
	render: function(){
		this.$el.append( this.template() );
		return this;
	},
	
	
	saveEntry: function(e){
		obj = this.getValue();
		
		if(!obj)
		{
			//All values must be entered..
			return false;	
		}
		//Adding the department..
		obj["department_id"] = this.department_id;
		var that = this;
		this.model.save(obj,{
			success: function( model, response ){
				that.resetEntry();
				console.log("Succesfully created faculty!");
				var message = "<strong>Faculty created</strong>.\
								<p> Faculty Name: <strong>" + obj.first_name + " " + obj.last_name  + "</strong></p>  \
								<p> Faculty Pass: <strong>" + response.pass_string + "</strong> </p> \
								<p><strong>Note</strong>:Change this password as soon as you login.</p>";
				that.displayMessage(message, app.Global.alertType[1] );
				//Now add this mode to the list...
				//app.Global.facultyList.add(that.model);
				//Now clearing the model id and everything....
				that.model.clear({silent:true});
				
			},
			error: function( model, response ){
				that.resetEntry();
				console.log("Error created faculty!");
				//var message = "<strong>Error</strong> creating faculty.";
				if( response.responseText.length< 30 )
				{
					var message = response.responseText;
				}
				else{
					var message = "Error creating faculty!";
				}
				
				that.displayMessage(message, app.Global.alertType[3] );
				//Now clearing the model id and everything....
				that.model.clear({silent:true});
			},
			
 			headers:{
				//Sending the faculty headers with headers..
				faculty_id     : faculty.id,
 			},
		});
		
		
	},
	
	
	resetEntry: function(){
		var firstName     = $("#faculty-first-name").val('');
		var lastName      = $("#faculty-last-name").val('');
		var userName      = $("#faculty-user-name").val('');
		var emailAddress  = $("#faculty-email-address").val('');
	},
	
	//Method if model validation fails..
	validationFailed: function(model){
		this.displayMessage(model.validationError, app.Global.alertType[3]);
	},
	
	
	//Function for diplaying result and console screen...
	displayMessage : function(message, type){
		var Template = _.template( $("#display-info").html() );
		this.display =  Template( {"message": message, "typeInfo": type } );
		//Callback for success 
		//Now adding this info to form display ..
		var displayElement = this.$el.find("#admin-faculty-info-box");
		$(displayElement).html(this.display);
	}
	
	
});





//------------------------------------------------------VIEWS FOR SHOWING LIST OF FACULTY-------------------------------------
//Accept a argument model of faculty...
//View for Creating Activity.....
//Provide department_id value rendering this..
//Child Views...

app.Views.ShowFaculty = Backbone.View.extend({
	
	initialize: function(){
		this.childViews  =  [];
		this.offset = 0;
		this.limit  = 10;
		
		this.facultyList = new app.Collection.Faculty;
		//initializing template for create faculty...
		this.template = _.template( $("#faculty-list-collection").html() );
		
		this.$el.append( this.template() );
		//For listening to validation error..
		this.listenTo(  this.facultyList , 'add',    this.addFacultyList );
		this.listenTo(  this.facultyList , 'reset',  this.resetFaculty );
		this.listenTo(  this.facultyList , 'remove', this.deleteFaculty );
		
		var that = this;
		//Adding the scrolling options for fetchin more enteries..
		//Adding window scroll option for infinite scroll options...
		$(window).scroll(_.debounce(function(){
   			if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
       			console.log("scroll position: near  bottom!");
				//Now fetch more collection on pagination options..
				that.fetchMore( );
      		}
   		},300));
		//this.fetchMore();
	},
	
	//For adding the faculty to the list..
	//also add childViews to clear memory..
	addFacultyList : function( model){
		console.log("Adding models;");
		var view  = new app.Views.FacultyItem( {"model": model} );
		view.listCollection = this.facultyList;
		this.childViews.push( view );
		$("ul.faculty-list").append( view.render().el );
	},
	
	//For resetting the faculty collection and adding new set of collection...
	resetFaculty : function( ){
		
		app.Global.facultyList.each(this.addFacultyList, this);
	},
	
	//Adding an function for fetching value from the 
	fetchMore:function(){
		var that = this;
		var add = false;
		if(parseInt(this.offset))
		{
			add = true;
		}
		//showing the loading bar....
		app.Global.showLoadingBar();
		this.facultyList.fetch({
			remove:false,
			data: {offset: that.offset, limit:that.limit, dept_id: that.department_id },
			//Adding an error callback...
			error: function(collection, response, options){
				app.Global.hideLoadingBar();
				console.log("Error fetching faculty list collection from server.");	
			},
			success: function(collection, response, options){
				app.Global.hideLoadingBar();
				if(response.length === 0 && !add )
				{
					that.destroy_view();	
					return false;
				}
				
				//Creating a global refrence of the collection...
				//app.Global.facultyList = that.facultyList;
				//Now updating  the offset..
				var length = response.length;
				that.offset = that.offset + length;	
			}
	 	});
	},
	
	
	deleteFaculty: function(){
		this.offset  = parseInt(this.offset) - 1;
	}
	
	
	
});


app.Views.FacultyItem  =  Backbone.View.extend({

	initialize: function(){
		//Resetting  a collection... 
		app.Global.facultyList.reset();
		//initializing template for create faculty...
		this.template = _.template( $("#faculty-list-item").html() );
		
		//For listening to validation error..
		//this.listenTo(  this.model , 'change',  this.render );
		this.listenTo(  this.model , 'destroy', this.deleteFaculty );
		this.detachElement = null;
	},
	
	
	tagName: "li",	
	
	className: "faculty-list-items",
	
	
	events:{
		"dblclick #faculty-list-item-full-name"  : "edit",
		"click #faculty-item-edit"               : "edit",
		"click #faculty-create-btn"				 : "updateModel",
		//Now handle delete..
		"click #faculty-item-delete"	         : "deleteModel",
		"click #faculty-reset-btn"               : "cancelUpdate" ,
		"click #entry-action-btn"                : "confirmDelete",
		"close.bs.alert #dept-display-box"       : "cancelDelete"
	},
	
	
	//Activates the edit option for faculty name...
	edit: function(e){
		e.preventDefault();
		var element = this.$el.find("#faculty-list-item-full-name");
		$(element).addClass('hide');
		this.detachElement = this.$el.find("p");
		this.detachElement = $(this.detachElement).detach();
		var inputElement = this.$el.find("#faculty-edit-list");
		$(inputElement).removeClass('hide');
		$(this.$el).css("margin-bottom","80px");
		$(this.$el).css("margin-top","50px");
	},
	
	cancelUpdate:function(){
		console.log("Updating the models...");
		var element = this.$el.find("#faculty-list-item-full-name");
		$(element).removeClass('hide');
		if(this.detachElement){
			this.$el.append( this.detachElement );	
			this.detachElement = null;
		}
		var inputElement = this.$el.find("#faculty-edit-list");
		$(inputElement).addClass('hide');
		$(this.$el).css("margin-bottom","0px");
		$(this.$el).css("margin-top","0px");
	},
	
	//Triggers on pressing the delete button...
	deleteModel: function(){
		this.detachElement = this.$el.find("p");
		this.detachElement = $(this.detachElement).detach();
		var element = this.$el.find("#faculty-list-item-full-name");
		$(element).addClass('h4');
	
		
		
		var deleteMessage = _.template($("#entry-log-alert-body").html());		
		this.displayMessage(deleteMessage(), app.Global.alertType[0] );
	},
	
	
	cancelDelete: function(){
		var element = this.$el.find("#faculty-list-item-full-name");
		$(element).removeClass('hide');
		$(element).removeClass('h4');
		if(this.detachElement){
			this.$el.append( this.detachElement );	
			this.detachElement = null;
		}
		var inputElement = this.$el.find("#faculty-edit-list");
		$(inputElement).addClass('hide');
		//$(this.$el).css("margin-bottom","0px");
		//$(this.$el).css("margin-top","0px");
		
	},
	
		
	confirmDelete: function(){
		if(faculty.id === this.model.get('id') ){
				var message = "<strong>Error:</strong> You cannot delete your <strong>own account</strong>. ";
				this.displayMessage( message, app.Global.alertType[0] );
				return false;
		}
		var element = this.$el.find("#faculty-list-item-full-name");
		$(element).removeClass('hide');
		$(element).removeClass('h4');
		if(this.detachElement){
			this.$el.append( this.detachElement );	
			this.detachElement = null;
		}
		var inputElement = this.$el.find("#faculty-edit-list");
		$(inputElement).addClass('hide');
		$(this.$el).css("margin-bottom","0px");
		$(this.$el).css("margin-top","0px");
		
	    this.model.destroy( {
		  success: function(){
			  console.log("successfully delete faculty from server..");	
		  },
		  error: function(){
			  console.log("Error deleting faculty from server..");
		  },
		  headers:{
			//Sending the faculty headers with headers..
			faculty_id     : faculty.id,
 		  }
		});
	},
	
	
	
	updateModel:function(e){
		console.log("Updating the models...");
		var element = this.$el.find("#faculty-list-item-full-name");
		$(element).removeClass('hide');
		if(this.detachElement){
			this.$el.append( this.detachElement );	
			this.detachElement = null;
		}
		var inputElement = this.$el.find("#faculty-edit-list");
		$(inputElement).addClass('hide');
		$(this.$el).css("margin-bottom","0px");
		$(this.$el).css("margin-top","0px");
		var obj = this.getValue();
		//Now checking the values...
		if(!obj)
		{
			var message = "Fields cannot be left <strong>blank</strong>"
			this.displayMessage( message, app.Global.alertType[3] );
			return false;
		}
		
		//Updating the model..
		this.model.set(obj);
		var that = this;
		//Now save this model to the server..
		this.model.save(null, {
			success: function(){
				console.log("successfully updated faculty info to the server..");
				var model = that.listCollection.get(that.model.get("id"));
				//Now change that view...
				that.render();
			},
			error: function(){
				console.log("Error updating faculty info to the server.");
				var message = "<strong>Errror</strong> updating faculty information to the server.<strong>Please try again sometime later</strong>";
				this.displayMessage( message, app.Global.alertType[3] );
			},
			headers:{
			//Sending the faculty headers with headers..
			faculty_id     : faculty.id,
 		  }
		});
		
	},
	
	
	
	getValue: function(){
		var firstNameElement    = this.$el.find("#faculty-edit-first-name");
		var first_name          = $(firstNameElement).val();
		
		var lastNameElement     = this.$el.find("#faculty-edit-last-name");
		var last_name           = $(lastNameElement).val();
		
		var usernameElement     = this.$el.find("#faculty-edit-username");
		var username            = $(usernameElement).val();
		
		var emailAddressElement = this.$el.find("#faculty-edit-email-address"); 
		var email_address	    = $(emailAddressElement).val();
		
		if(!first_name.length && !last_name.length && !username.length  && !email_address.length  ){
			return false;
		}
		
		var obj = {
			"first_name"    : first_name,
			"last_name"     : last_name,
			"username"	    : username,
			"email_address" : email_address
		}
		
		return obj;
		
	},
	
	
	render: function(){
		console.info("Rendering the faculty item model");
		this.$el.empty();
		var name = this.model.get("first_name") + " " + this.model.get("last_name");
		//adding this to the model...
		this.model.set("name", name);
		var itemElement =  this.template( this.model.toJSON() );
		this.$el.append(itemElement);
		return this;
	},
	

	
	
	//On removing a faculty model from collection...
	//Always use collection.remove method...
	deleteFaculty : function( model ){
		//First remove this model from collection and then destroy this view...
		app.Global.facultyList.remove(model);
		//Now destroy this view...
		this.destroy_view();
	},
	
	
	
	//Function for diplaying result and console screen...
	displayMessage : function(message, type){
		var Template = _.template( $("#display-info").html() );
		this.display =  Template( {"message": message, "typeInfo": type } );
		//Callback for success 
		//Now adding this info to form display ..
		var displayElement = this.$el.find("#faculty-list-item-display-info");
		$(displayElement).html(this.display);
	}


});



//----------------------------------------------VIEW FOR LOADING ACTIVITY-----------------------------
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
	
	
	
	
	//Adding an function for fetching value from the 
	fetchMore:function(){
		var that = this;
		
		//showing the loading bar....
		app.Global.showLoadingBar();
		var facultyId =  faculty.id;
		this.collection.fetch({
			data: {offset: that.offset, limit:that.limit, faculty_id: facultyId},
			remove:false,
			//Adding an error callback...
			error: function(collection, response, options){
				app.Global.hideLoadingBar();
				console.log("Error fetching collection from admin_log collection.");	
			},
			success: function(collection, response, options){
				app.Global.hideLoadingBar();
				console.log("Successfully fetched data of admin_log from server.");
				//Now updating  the offset..
				var length = response.length;
				that.offset = that.offset + length;	
			}
		 });
	},//End of fetch more function...
	
	
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
		var EntryView = new app.Views.activityModel({model: logModel});
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

//------------------------------------------------------VIEW FOR LOADING A MODEL------------------------------------------


app.Views.activityModel = Backbone.View.extend({
	initialize:function(){
		// Cache the template function for a single item.
    	this.template 				= _.template( $('#faculty_home_log').html() );
	},
	
	//... is a list tag.
    tagName:  "li",

	// Re-render the titles of the todo item.
    render: function() {
      this.$el.html(this.template(this.model.toJSON()));
      return this;
    }
});



//--------------------------------------------VIEW FOR SETTINGS-------------------------------------------------------

app.Views.settings  = Backbone.View.extend({
	initialize: function(){
		//Setting the current views....
		app.Global.Router.currentView = this;
		this.template   =  _.template( $("#template-reset-settings").html() );

	},
	
	
	events:{
	  "click #settings-delete-btn"   :  "confirmDelete",
	  "click #alert_modal_save_btn"  :  "confirmPassBtn"
	},
	
	// Re-render the setting page....
    render: function() {
		
	  this.$el.html(this.template());
      
      return this;
    },
	
	//Loading the  
	confirmDelete:function()
	{
		var modalTemplate = _.template( $("#alert-password-confirm-modal").html() );
		this.$el.append( modalTemplate() );
		//Now load the modal..
		//$('#myModal').modal(options)
		var modalElement = this.$el.find("#myModal");
		$('#myModal').modal('show');
	},
	
	
	
	confirmPassBtn: function(){
		//get the inputed password...
		var getPassElement = this.$el.find("#pass-confirm");
		var getPass = $(getPassElement).val();
		if(getPass === '')
		{
			console.warn("Pass must be entered");
			return false;	
		}
		//Getting the pass md5 hash
		var hash = CryptoJS.MD5(getPass);
		console.log("Confirm Password is " + hash.toString());
		var that = this;
		//First send an delete request to the server...
		$.ajax({
    		url: '/Manage/modules/department.php/settings',
    		type: 'DELETE',
    		success: function(result) {
        		// Do something with the result
				console.info("Succesfullty reset entry");
				that.displayMessage("Data entry <strong>successfully deleted.</strong>", app.Global.alertType[1]);
				
    		},
			error:function(){
				that.displayMessage("<strong>Error wrong password.</strong> Please type your <strong>password correctly</strong>.", app.Global.alertType[3]);
			},
			
			headers:{
				password   : hash.toString(),
				faculty_id : faculty.id
			}
		});
		//Now closing the modal...
		var modalElement = this.$el.find("#myModal");
		$('#myModal').modal('hide');
	},
	
	
	
	
	//Function for diplaying result and console screen...
	displayMessage : function(message, type){
		var Template = _.template( $("#display-info").html() );
		this.display =  Template( {"message": message, "typeInfo": type } );
		//Callback for success 
		//Now adding this info to form display ..
		var displayElement = this.$el.find("#settings-delete-info");
		$(displayElement).html(this.display);
	}
	
	
});































