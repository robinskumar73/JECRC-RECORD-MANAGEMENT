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
	model:app.Model.Faculty,
	url:"/Manage/modules/department.php/members",
	//Sorting the collection in decreasing order of date..
	comparator: function(Model) {
		return [-Model.get("first_name"), -Model.get("last_name")];
	},
});




app.Collection.periodEntry = Backbone.Collection.extend({
	
	model:app.Model.periodEntry,
	url:"/Manage/modules/department.php/period/entry",
	
	//Sorting the collection in decreasing order of date..
	comparator: function(Model) {
		return [-Model.get("date")];
	},
});




//Collection for faculty entry...
app.Collection.faculty_entry = Backbone.Collection.extend({
	model:app.Model.faculty_entry,
	//Adding the url for fecthing the value from the server...
	//url:"/Manage/modules/department.php/entry/faculty/" + faculty.id + "/daysEntry",
	
	url:"/Manage/modules/department.php/faculty/activity",
	
	//Sorting the collection in decreasing order of date..
	comparator: function(Model) {
		var date = new Date(Model.get("date"));
		return -date.getTime();
	}
});






