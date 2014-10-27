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


app.Model.Subject = Backbone.Model.extend({
	defaults:{
		id:null,
		subject:''
	}
});



//Model for faculty entry...
app.Model.faculty_entry = Backbone.Model.extend({
	defaults:{
		id:null,
		date: '',
		time: '',
		entry_type:	'',
		info_entry_id: null,
		faculty_id: null,
		info:	'',
		sub_info:'',
		last_update_type:null, //Will be either delete or update and error if update results in an error
		last_updated_time:null
	},
	
	urlRoot:"/Manage/modules/department.php/faculty/activity",
	
	//Function for validating the model..
	validate: function(attrs, options) {
		//checking for sub_info ...
		//checking for info...
		var datePattern			= /^([0-9]{4})\s*\-\s*([0-9]{1,2})\s*\-\s*([0-9]{1,2})$/;
		var infoPattern 		= /[^\d\s\w\.\-]/;
		var infoEntryIdPattern  = /[^\d]/;
		if( infoPattern.test( attrs.info ) || infoPattern.test(attrs.sub_info) ){
			//Error occured......
			return "<strong>Error: </strong> Invalid characters inputted in activity log.";	
		}
		
		if( attrs.info_entry_id && infoEntryIdPattern.test( attrs.info_entry_id ) )
		{
			//Error occured......
			return "<strong>Error: </strong> Invalid characters inputted in info_entry_id.";
		}
		
		if(!datePattern.test(attrs.date))
		{
			//Error occured......
			return "<strong>Error: </strong> Invalid date format. Only this format is supported <strong>'yyyy-dd-mm'</strong>";
		}
		
	}//End of validate function...
});//End of model faculty entry...





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
		days_entry_id:""
		
	},
	
	urlRoot:"/Manage/modules/department.php/period/entry",
	
	validate: function(attrs, options) {
		//Now validating the subject_name..
		var subject = attrs.subject_name;
		var datePattern				= /^([0-9]{4})\s*\-\s*([0-9]{1,2})\s*\-\s*([0-9]{1,2})$/;
		var subject_pattern		    = /[^\d\s\w\.\-]/;
		var strength_pattern 		= /[^\d]/;
		if( subject_pattern.test( subject ) ){
			//Error occured......
			return "<strong>Error: </strong> Invalid characters inputted in subject. Only <strong >digits, alphabets, period(.) and spaces  </strong> are allowed for naming subject ";	
		}
		if( strength_pattern.test( attrs.strength ) ){
			//Error occured......
			return "<strong>Error:</strong>  Use only <strong>digits</strong> for strength entry";	
		}
		if( /[^0|1]/.test( attrs.lab ) ){
			//Error occured......
			return "<strong>Error:</strong>  Lab must be a <strong>boolean</strong> value.";	
		}
		if(attrs.date && !datePattern.test(attrs.date))
		{
			//Error occured......
			return "<strong>Error: </strong> Invalid date format. Only this format is supported <strong>'yyyy-dd-mm'</strong>";
		}
		
	}//End of validate function..
	
});









