// JavaScript Document
// js/collections/hashbang-collections
// Script written by Robins Gupta.

//Residing everything under a global namespace "app"


var app = app || {};
app.Collection = app.Collection || {};

//NOTE:semester will always get added through deparment..and never alone
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
	
	url_func: function(){
		console.log(this.parent);
		this.url = '/modules/department.php/department/' + this.parent.parent.get('id') + '/semester/' + this.parent.parent.Semester.get('id')  + '/section/' + this.parent.get('id') + '/batch';
	},
	
	model: app.Model.Batch 
});

//Adding batch collection to Section...
app.Model.Section.prototype.url_func = function(){
	//Storing Navigation Link Collection...
	
	this.Batch = new app.Collection.Batch;
	this.Batch.parent = this;
	//Lazy loading of url to batch..
	this.Batch.url_func();
		
}