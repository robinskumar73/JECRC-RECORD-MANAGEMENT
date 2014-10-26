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



