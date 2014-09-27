//static/customscript/myscript
//JECRC RECORD MANAGEMENT
//Script Written By Robins Gupta

$(document).ready(function(e) {
    

	var fetching =   app.Global.Department.fetch({
		error: function () {
			console.log('Error fetching department..');
		},
		success: function(){
			console.log('Successfully fecthed department data..');	
		}
	});

});



/*
//fetching database values of department...
console.log(app);
app.Global.Department.fetch({
	error: function (model, response) {
		console.log('Error fetching department..');
	},
	success: function(){
		console.log('Successfully fecthed department data..');	
	}
});	
*/