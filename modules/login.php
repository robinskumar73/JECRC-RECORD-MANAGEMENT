<?php
	require_once('database_connection.php');
	$error_msg = "";
	
	if(!isset($_COOKIE['id']))
		{
			if(isset($_POST['submit']))
			{
				$dbc = mysqli_connect(HOST,USERNAME,PASSWORD,DATABASE) or die('Connection Failed');
				$user_username = mysqli_real_escape_string($dbc,trim($_POST['username']));
				$user_password = mysqli_real_escape_string($dbc,trim($_POST['password']));
				if(!empty($user_username) && !empty($user_password))
				{
					$query = "SELECT id,username FROM faculty WHERE username='$user_username' AND password=SHA('$user_password')";
					$data = mysqli_query($dbc,$query);
					
					if(mysqli_num_rows($data) == 1)
					{
						$row = mysqli_fetch_array($data);
						setcookie('id',$row['id']);
						setcookie('username',$row['username']);
					}
					else
					{
						$error_msg = "Sorry, you must enter a correct username and password to log in";
					}
				}
				else
				{
					$error_msg = "Sorry, you must enter your username or password to log in";
				}
			}
			
		}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Login</title>
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
        	<div class="col-md-6 col-xs-12 col-md-offset-3 login">
            	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" role="form">
                	<fieldset>
                    	<legend>Log In</legend>
                        <label for="username">Username</label><br />
            			<input type="text" id="username" name="username"  class="form-control"																													                          value=" <?php if(!empty($user_username)) echo $user_username; ?>" /><br />
            			<label for="password">Password</label><br />
                        <input type="password" id="password" name="password" class="form-control" /><br />
                    </fieldset>
                    <input type="submit" id="submit" value="Log In" class="btn btn-success"  />
                </form>
            </div><!--Div for Login end here-->
        </div><!--Div for second row End here-->
    </div><!--Div for container fluid end here-->
</body>

</html>