// JavaScript Document
// js/models/jecrc-model

//Residing everything under a global namespace "app"

//NOTE:: BOOKMARK MODEL HAS NOT BEEN CREATED...

var app = app || {};
app.Model = app.Model || {};


app.Model.Semester = Backbone.Model.extend({
	defaults:{
		id:null,
		name:'NOT ASSIGNED'	
	}
});


app.Model.Batch = Backbone.Model.extend({
		defaults:{
			id:null,
			name:'NOT ASSIGNED'
		}
});


app.Model.Section = Backbone.Model.extend({
	defaults:{
		id:null,
		name:'NOT ASSIGNED'
	}
});
