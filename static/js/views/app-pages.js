// JavaScript Document
// js/views/app-pages
// Script written by Robins Gupta.
//Designed


//Creating model for department ..
//NOTE SECTION,BATCHES AND SEMESTER VALUE ARE NEVER GETTING TO BE SAVED TO THE SERVER ONLY DEPARTMENT WILL GET SAVED..

app.Model.Department = Backbone.Model.extend({
	
	initialize:function(){	
		//Storing Navigation Link Collection...
		this.Semester = new app.Model.Semester;
		this.Semester.parent = this;

		this.Section = new app.Model.Section;
		this.Section.parent = this;
		this.Section.url_func();
		//Attaching url..for get,delete, put,post
		//this.Section.url = '/department/' + this.id + '/semester/' + this.Semester.id + '/section';
		
		
	},
	
	defaults:{
		id:null,
		name:'NOT ASSIGNED'
	}
});


app.Collection.Department = Backbone.Collection.extend({
	model: app.Model.Department,
	url: 'modules/department.php/department'
});

