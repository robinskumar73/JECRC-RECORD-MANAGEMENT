// JavaScript Document
// js/models/jecrc-model

//Residing everything under a global namespace "app"

//NOTE:: BOOKMARK MODEL HAS NOT BEEN CREATED...

var app = app || {};
app.Model = app.Model || {};


//Creating model for department ..
app.Model.Department = Backbone.Model.extend({
	defaults:{
		id:null,
		name:'NOT ASSIGNED'
	},
	
});




app.Model.Branch = Backbone.Model.extend({
	defaults:{
		id:null,
		department_id:null,
		semester_id:null,
		section_name:'UNDEFINED',
		batch_id:null
	}
});



app.Model.Faculty = Backbone.Model.extend({
	defaults:{
		id:null,
		first_name:'',
		last_name:'',
		username:'',
		department_id:null	
	}
});


//Adding model information for period entry...
app.Model.periodEntry = Backbone.Model.extend({
	defaults:{
		id:null,
		date:"",
		subject_name:"",
		faculty_id:null,
		faculty_name:"",
		lab:0, //0 or 1
		batch:null,
		period:[], // must be an array containing values[]
		strength:0,
		department_id:null,
		semester_id:null,
		section_name:null,
		
	}
});









