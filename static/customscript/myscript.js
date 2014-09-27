//static/customscript/myscript
//JECRC RECORD MANAGEMENT
//Script Written By Robins Gupta

//fetching database values of department...
app.Global.Department.fetch({
	error: function (model, response) {
		console.log('Error fetching department..');
	},
	success: function(){
		console.log('Successfully fecthed department data..');	
	}
});	