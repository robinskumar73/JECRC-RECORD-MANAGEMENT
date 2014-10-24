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
	url:"/Manage/modules/department.php/entry/department/daysEntry",
	
	//Sorting the collection in decreasing order of date..
	comparator: function(periodEntryModel) {
		return -periodEntryModel.get("date");
	}
});

//Collection for faculty entry...
app.Collection.faculty_entry = Backbone.Collection.extend({
	model:app.Model.faculty_entry,
	//Adding the url for fecthing the value from the server...
	url:"/Manage/modules/department.php/entry/faculty/" + faculty.id + "/daysEntry",
	
	//Sorting the collection in decreasing order of date..
	comparator: function(Model) {
		return Model.get("date");
	},
	
	//For getting the date wise entry object ...
	/*
	{
		12-04-2014:[contains list of model of this date],
	}
		
	*/
	getDateWiseEntry: function(){
		var dateWiseFacultyEntry = {};	
		//Getting the list of unique dates...
		var dateList = $.unique(this.pluck("date"));
		//Now arraging the list according to the array...
		for (var i = 0; i< dateList.length; i++)
		{
			dateWiseFacultyEntry[dateList[i]] = this.where({ date: dateList[i] });	
		}
		return dateWiseFacultyEntry;
	}
	
	
	
});






