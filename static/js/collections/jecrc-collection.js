// JavaScript Document
// js/collections/hashbang-collections
// Script written by Robins Gupta.

//Residing everything under a global namespace "app"


var app = app || {};
app.Collection = app.Collection || {};

app.Collection.Department = Backbone.Collection.extend({
	model: app.Model.Department,
	url: '/Manage/modules/department.php/department'
});




app.Collection.Branch = Backbone.Collection.extend({
	model: app.Model.Branch,
	url: '/Manage/modules/department.php/branch'
});

app.Collection.Subject = Backbone.Collection.extend({
	model:app.Model.Subject
});



app.Collection.Faculty = Backbone.Collection.extend({
	model:app.Model.Faculty
});

app.Collection.periodEntry = Backbone.Collection.extend({
	
	model:app.Model.periodEntry,
	//url is used only in case of posting values...
	url:"/entry/department/daysEntry",
	
	//Sorting the collection in decreasing order of date..
	comparator: function(periodEntryModel) {
		return -periodEntryModel.get("date");
	}
});






