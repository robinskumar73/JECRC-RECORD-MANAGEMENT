// JavaScript Document
// js/collections/hashbang-collections
// Script written by Robins Gupta.

//Residing everything under a global namespace "app"


var app = app || {};
app.Collection = app.Collection || {};

app.Collection.Department = Backbone.Collection.extend({
	model: app.Model.Department,
	url: 'modules/department.php/department'
});


app.Collection.Class = Backbone.Collection.extend({
	model: app.Model.Class
});

app.Collection.ClassEntry = Backbone.Collection.extend({
	model: app.Model.ClassEntry
});

app.Collection.ClassJoin = Backbone.Collection.extend({
	model: app.Model.ClassJoin
});


app.Collection.Branch = Backbone.Collection.extend({
	model: app.Model.Branch,
	url: 'modules/department.php/branch'
});


app.Collection.MainEntry = Backbone.Collection.extend({
	model:app.Model.MainEntry
});


app.Collection.Faculty = Backbone.Collection.extend({
	model:app.Model.Faculty
});


app.Collection.Lab = Backbone.Collection.extend({
	model:app.Model.Lab
});

app.Collection.LabJoin = Backbone.Collection.extend({
	model:app.Model.LabJoin
});


app.Collection.LabEntry = Backbone.Collection.extend({
	model:app.Model.LabEntry
});


/*
app.Collection.Semester = Backbone.Collection.extend({
	model: app.Model.Semester,
	//Attaching url.. for get,delete,put
	//url : '/semester'	
});

app.Collection.Section = Backbone.Collection.extend({
	model: app.Model.Section	
});

//Batch must not be added alone...
app.Collection.Batch = Backbone.Collection.extend({
	model: app.Model.Batch 
});
*/

