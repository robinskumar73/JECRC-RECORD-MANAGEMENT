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
	
	$.when(fetching).done(function(){
		dept_views.render();
		var department = app.Global.Department.pluck("name");
		var dept = JSON.stringify(department);
		
		
		$('#DepartmentCreate .typeahead').typeahead({
		  hint: true,
		  highlight: true,
		  minLength: 1
		},
		{
		  name: 'dept',
		  displayKey: 'value',
		  source: substringMatcher(department)
		});
	});

});

//---------------------------------------------AREA FOR TYPE AHEAD-----------------------------------
var substringMatcher = function(strs) {
  return function findMatches(q, cb) {
    var matches, substrRegex;
 
    // an array that will be populated with substring matches
    matches = [];
 
    // regex used to determine if a string contains the substring `q`
    substrRegex = new RegExp(q, 'i');
 
    // iterate through the pool of strings and for any string that
    // contains the substring `q`, add it to the `matches` array
    $.each(strs, function(i, str) {
      if (substrRegex.test(str)) {
        // the typeahead jQuery plugin expects suggestions to a
        // JavaScript object, refer to typeahead docs for more info
        matches.push({ value: str });
      }
    });
 
    cb(matches);
  };
};
 


