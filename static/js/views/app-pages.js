// JavaScript Document
// js/views/app-pages
// Script written by Robins Gupta.
//Designed

//Residing everything under a global namespace "app"
var app = app || {};

//Now create a global variable accesing department list..
app.Global = app.Global || {};

//Some global variable definition...
app.Global.Department     			= new app.Collection.Department;
app.Global.Branch         			= new app.Collection.Branch;
app.Global.Subjects       			= new app.Collection.Subject;
app.Global.entryLogCollection 		= new app.Collection.faculty_entry;
app.Global.facultyList              = new app.Collection.Faculty;


//Other global values related to admin page..
app.Global.DepartmentPresentAlready = false;
app.Global.DepartmentElementObj		= null;


//Extending the backbone view...
Backbone.View.prototype.destroy_view = function()
{ 
	//for doing something before closing...useful for closing the child views...
	if (this.beforeClose) {
        this.beforeClose();
    }
	this.undelegateEvents();
	$(this.el).removeData().unbind(); 
	//Remove view from DOM
	this.remove();  
	Backbone.View.prototype.remove.call(this);
}



//Function for doing before closing the view...
Backbone.View.prototype.beforeClose  = function(){
	console.info("Closing the child views...");
	if(this.childViews){
	  var len = this.childViews.length;
	  for(var i=0; i<len; i++){
		  this.childViews[i].destroy_view();
	  }
	}//End of if statement
} //End of beforeClose function




app.Global.showLoadingBar = function(){
	console.log("Showing the loading bar..");
	$('#loading-bar').removeClass('hide');	
	
}

app.Global.hideLoadingBar = function(){
	console.log("Hiding the loading bar..");
	$('#loading-bar').addClass('hide');	
}


//Function for custom selecting autocomplete ...
customSubjectSelectize = function(elementObj){
	
	//Initializing the selectize function...
	subjectSelect = $(elementObj).selectize({
		
		//Now instantiating values for selectize..
		theme:false  ,
		maxItems: 1,
		valueField:  'subject',
		searchField: 'subject',
		labelField: 'subject',
		
		
		
		options: [],

	
		load: function(query, callback) {
			if (!query.length) return callback();
			$.ajax({
				url: 'http://localhost/Manage/modules/department.php/subject?key='+query,
				type: 'GET',
				dataType: 'json',
				error: function() {
					callback();
				},
				success: function(res) {
					callback(res);
				}
			});
		},

			
		render: {
			option: function(item, escape) {
	
			return '<div>' +
				'<span class="auto-title">' +
				'<span class="auto-name">' + escape(item.subject) + '</span>' +
				'</span>' +
			'</div>';
		}
	        },



		create: function(input) {
			return {
				id: null,
				subject: input,
			};
		}
	});//End of selectize function..
	
	// show current input values
	$('select.selectized,input.selectized').each(function() {
		var update = function(e) { 
			console.log("Getting added..");
			console.log(e);
			
		}
		
		$(this).on('add', update);
		//update();
	});
	
	//Now returning the object...
	return subjectSelect;
	
}




//Function for custom selecting autocomplete ...
customDepartmentSelectize = function(elementObj){
	
	//Initializing the selectize function...
	deptSelect = $(elementObj).selectize({
		
		//Now instantiating values for selectize..
		theme:false  ,
		maxItems: 1,
		valueField:  'id',
		searchField: 'name',
		labelField: 'name',
		create:false,
	
		options: [],

	
		load: function(query, callback) {
			if (!query.length) return callback();
			$.ajax({
				url: 'http://localhost/Manage/modules/department.php/department?key='+query,
				type: 'GET',
				dataType: 'json',
				error: function() {
					callback();
				},
				success: function(res) {
					callback(res);
				}
			});
		},

			
		/*render: {
			option: function(item, escape) {
	
			  return '<div>' +
				  '<span class="auto-title">' +
				  '<span class="auto-name">' + escape(item.subject) + '</span>' +
				  '</span>' +
			  '</div>';
			}
	    },*/
		
	});//End of selectize function..
	//Now returning the object...
	return deptSelect;
}



//---------------------------------------------------HELPER FUNCTIONS----------------------------------------------


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
		0:"Sunday",
		1:"Monday",
		2:"Tuesday",
		3:"Wednesday",
		4:"Thursday",
		5:"Friday",
		6:"Saturday"
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





