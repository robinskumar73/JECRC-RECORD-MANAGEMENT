// JavaScript Document
// js/views/app-pages
// Script written by Robins Gupta.
//Designed

//Residing everything under a global namespace "app"
var app = app || {};


//Now create a global variable accesing department list..
app.Global = app.Global || {};

app.Global.showLoadingBar = function(){
	$('#loading-bar').removeClass('hide');	
	
}

app.Global.hideLoadingBar = function(){
	$('#loading-bar').addClass('hide');	
}

$(document).ready(function(e) {
	console.log(faculty);
	app.Global.facultyModel = new app.Model.Faculty(faculty);    
});



