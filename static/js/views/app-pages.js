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



//Now create a global variable accesing department list..
app.Global = app.Global || {};


//Extending the backbone view...
Backbone.View.prototype.destroy_view = function()
{ 
	//COMPLETELY UNBIND THE VIEW
	console.info("Destroying the view!  ");
	this.undelegateEvents();
	$(this.el).removeData().unbind(); 
	//Remove view from DOM
	this.remove();  
	Backbone.View.prototype.remove.call(this);
}



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



