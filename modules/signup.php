<?php
require_once('database_connection.php');
$dbc = mysqli_connect(HOST,USERNAME,PASSWORD,DATABASE) or die('Connection Failed');
if(isset($_POST['submit']))
{
	$first_name = mysqli_real_escape_string($dbc,trim($_POST['first_name']));
	$last_name = mysqli_real_escape_string($dbc,trim($_POST['last_name']));
	$username = mysqli_real_escape_string($dbc,trim($_POST['username']));
	$password1 = mysqli_real_escape_string($dbc,trim($_POST['password1']));
	$password2 = mysqli_real_escape_string($dbc,trim($_POST['password2']));
	$department = mysqli_real_escape_string($dbc,trim($_POST['department']));
	
	if(!empty($username) && !empty($password1) && !empty($password2) && ($password1==$password2) && !empty($first_name) && 
		!empty($last_name) && !empty($department))
	{
		$query = "SELECT * FROM faculty WHERE username = '$username'";
		$data = mysqli_query($query);
		if(mysqli_num_rows == 0 )
		{
			$query = "INSERT INTO faculty (first_name,last_name,username,password,department) VALUES".
					   "('$first_name','$last_name','$username',SHA('$password1'),'$department');";
					   mysqli_query($dbc,$query);
			// Confirm Success to user
			
			
			mysqli_close($dbc);
			exit();
		}
		else
		{
			//An account already exsit , display an error message
		}
	}
	else
	{
		//User must Enter all details before submitting the form
	}
}
mysqli_close($dbc);

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Sign Up</title>
<?php
	require_once('css.php');
?>
</head>

<body>
<div class="container-fluid">
    	<div class="row">
        	<div class="col-md-12 col-xs-12">
            	<img src="../images/logo.jpg">
            </div><!--Div for Image end here--> 
        </div><!--Div for first row end here-->
        
        <div class="row">
        	<div class="col-md-6 col-xs-12 col-md-offset-3 signup">
            	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" role="form">
                	<fieldset>
                    	<legend>Sign Up</legend>
                        <label for="first_name">First Name</label><br />
            			<input type="text" id="first_name" name="first_name"  class="form-control"																													                          value=" <?php if(!empty($first_name)) echo $first_name; ?>" /><br />
                        <label for="last_name">Last Name</label><br />
            			<input type="text" id="last_name" name="last_name"  class="form-control"																													                          value=" <?php if(!empty($last_name)) echo $last_name; ?>" /><br />
                        <label for="username">Username</label><br />
            			<input type="text" id="username" name="username"  class="form-control"																													                          value=" <?php if(!empty($user_username)) echo $user_username; ?>" /><br />
            			<label for="password">Password</label><br />
                        <input type="password" id="password" name="password" class="form-control" /><br />
                        <label for="department">Department</label><br />
            			<input type="text" id="department" name="department"  class="form-control"																													                          value=" <?php if(!empty($first_name)) echo $first_name; ?>" /><br />
                    </fieldset>
                    <input type="submit" id="submit" value="Sign Up" class="btn btn-success"  />
                     <input type="button" id="cancel" value="Cancel" class="btn btn-danger"  />
                </form>
            </div><!--Div for Login end here-->
        </div><!--Div for second row End here-->
    </div><!--Div for container fluid end here-->
</body>
</html>