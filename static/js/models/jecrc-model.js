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
	}
});



app.Model.Class = Backbone.Model.extend({
	defaults:{
		id:null,
		department_id:null,
		section_id:null,
		semester_id:null	
	}
});


app.Model.ClassEntry = Backbone.Model.extend({
	defaults:{
		id:null,
		class_id:null,
		period_id:null,
		strength:'UNDEFINED'	
	}
});

app.Model.ClassJoin = Backbone.Model.extend({
	defaults:{
		main_entry_id:null,
		class_entry_id:null
	}
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

app.Model.MainEntry = Backbone.Model.extend({
	defaults:{
		id:null,
		faculty_id:null,
		date:'',
		subject:''	
	}
});

app.Model.Faculty = Backbone.Model.extend({
	defaults:{
		id:null,
		first_name:'',
		last_name:'',
		username:'',
		session_id:null,
		department_id:null	
	}
});


app.Model.Lab = Backbone.Model.extend({
	defaults:{
		id:null,
		class_id:null,
		batch_id:null	
	}
});

app.Model.LabJoin = Backbone.Model.extend({
	defaults:{
		lab_entry_id:null,
		main_entry_id:null
	}
});

app.Model.LabEntry = Backbone.Model.extend({
	defaults:{
		id:null,
		lab_id:null,
		strength:''	
	}
});




/*app.Model.Semester = Backbone.Model.extend({
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
*/