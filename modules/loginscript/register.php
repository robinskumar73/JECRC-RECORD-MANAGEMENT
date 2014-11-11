<?
include 'include/mail.php';
include 'include/constants.php';
include_once 'include/processes.php';
$Login_Process = new Login_Process;
$New = $Login_Process->Register($_POST, $_POST['process']);
ini_set("session.gc_maxlifetime", 0); 
session_start();
$_SESSION['register'] = "test";
?>



<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Password Reset</title>
	<link href="../../static/bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet">
	<link href="../../static/customstyle/mystyle.css" type="text/css" rel="stylesheet">
    <link href="../../static/selectize.js-master/dist/css/selectize.bootstrap3.css" type="text/css" rel="stylesheet">
    <!--script area-->
	<script src="../../static/jquery/jquery-1.7.2.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script type="text/javascript" src="../../static/bootstrap/js/bootstrap.js"></script>

	<script type="text/javascript" src="../../static/selectize.js-master/dist/js/standalone/selectize.min.js"></script>
</head>

<body>
	<div class="container-fluid">
    	<div class="row">
        	<div class="col-md-12 col-xs-12">
            	<img src="../../images/logo.jpg">
            </div><!--Div for Image end here--> 
        </div><!--Div for first row end here-->

        
        <div class="row">
        	<div class="col-md-6 col-xs-12 col-md-offset-3 login">




<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

<div class="right" style="margin-top:-8px; margin-right:-6px;"><a href="../../../index.php">Log In</a></div>
<h1>Register</h1>

<div class="red bg-danger">
<?php  echo $New; ?>
</div>
<br />

<input placeholder="First Name" name="first_name" type="text" class="field form-control" value="<? echo $_POST['first_name']; ?>" />
<br />

<input placeholder="Last Name" name="last_name" type="text" class="field form-control" value="<? echo $_POST['last_name']; ?>" /><br />

<input placeholder="Email Address" name="email_address" type="text" class="field form-control" value="<? echo $_POST['email_address']; ?>" />
<br />

<input id="department_id" placeholder="Department Id" name="department_id" type="text" class="field form-control" value="<? echo $_POST['department_id']; ?>" />

<br /><br />

<input placeholder="Password" name="pass1" type="password" class="field form-control"/>
<br />
<input placeholder="Confirm Password" name="pass2" type="password" class="field form-control"/>

<br /><br />

<input placeholder="Username" name="username" type="text" class="field form-control" value="<? echo $_POST['username']; ?>" />
<br />
<div class="right">
  <input name="process" type="submit" class="button btn btn-success" id="process" value="Register"/>
</div>

</form>

<script>
$(document).ready(function(e) {
    //adding the selectize on department..
	customDepartmentSelectize($("#department_id"));
});


//Function for custom selecting autocomplete ...
customDepartmentSelectize = function(elementObj){
	
	//Initializing the selectize function...
	deptSelect = $(elementObj).selectize({
		
		//Now instantiating values for selectize..
		theme:false  ,
		maxItems: 1,
		valueField:  'id',
		searchField: 'name',
		labelField: 'name',
		create:false,
	
		options: [],

	
		load: function(query, callback) {
			if (!query.length) return callback();
			$.ajax({
				url: 'http://booklite.in/Manage/modules/department.php/department?key='+query,
				type: 'GET',
				dataType: 'json',
				error: function() {
					callback();
				},
				success: function(res) {
					callback(res);
				}
			});
		},

			
		/*render: {
			option: function(item, escape) {
	
			  return '<div>' +
				  '<span class="auto-title">' +
				  '<span class="auto-name">' + escape(item.subject) + '</span>' +
				  '</span>' +
			  '</div>';
			}
	    },*/
		
	});//End of selectize function..
	//Now returning the object...
	return deptSelect;
}


</script>





</body>
</html>