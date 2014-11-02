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



