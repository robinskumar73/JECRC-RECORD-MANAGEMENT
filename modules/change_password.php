<?php
	require_once('database_connection.php');
	$dbc = mysqli_connect(HOST,USERNAME,PASSWORD,DATABASE) or die('Connection Failed');
	if(isset($_POST['submit']))
	{
		//Grab data from the form
		$user_username = mysqli_real_escape_string($dbc,trim($_POST['username']));
		$user_oldpassword = mysqli_real_escape_string($dbc,trim($_POST['oldpassword']));
		$user_newpassword1 = mysqli_real_escape_string($dbc,trim($_POST['newpassword1']));
		$user_newpassword2 = mysqli_real_escape_string($dbc,trim($_POST['newpassword2']));
		$query="SELECT * FROM logintable";
		$result=mysqli_query($dbc,$query);
		if(mysqli_num_rows($result)==1)
				{
					$row=mysqli_fetch_array($result);
					$id=$row['id'];
					
				}
		
		if(!empty($user_username) && !empty($user_oldpassword) && !empty($user_newpassword1) && !empty($user_newpassword2) &&
			($user_newpassword1 == $user_newpassword2) && SHA('$user_oldpassword') == $row['password'] )
			{
				$query="UPDATE faculty SET username='$user_username', password=SHA('$user_newpassword1') WHERE id='$id'";
				$result=mysqli_query($dbc,$query);
				$query="SELECT id,username FROM faculty WHERE username='$user_username' AND password=SHA('$user_newpassword1')";
				$result=mysqli_query($dbc,$query);
				if(mysqli_num_rows($result)==1)
				{
					$row=mysqli_fetch_array($result);
					setcookie('id',$row['id']);
					setcookie('username',$row['username']);
					$home_url='';
					header('Location:'.$home_url);
					
				}
				else
				{
					
					
				}
			}
		
	}
	else
	{
		$user_newpassword1 = "";
		$user_newpassword2 = "";
		$user_oldpassword = "";
	}
	
	mysqli_close($dbc);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Change Password</title>
<?php require_once('css.php'); ?>
</head>

<body>
	<div class="container-fluid">
    	<div class="row">
        	<div class="col-md-12 col-xs-12">
            	<img src="../images/logo.jpg">
            </div><!--Div for Image end here--> 
        </div><!--Div for first row end here-->
        
        <div class="row">
        	<div class="col-md-6 col-xs-12 col-md-offset-3 changepassword">
            	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" role="form">
                	<fieldset>
                    	<legend>Change Password</legend>
                        <label for="username">Username</label><br />
            			<input type="text" id="username" name="username"  class="form-control"																													                          value=" <?php if(!empty($user_username)) echo $user_username; ?>" /><br />
            			<label for="oldpassword">Old Password</label><br />
                        <input type="password" id="oldpassword" name="oldpassword" class="form-control" /><br />
                        <label for="newpassword1">New Password</label><br />
                        <input type="password" id="newpassword1" name="newpassword1" class="form-control" /><br />
                        <label for="newpassword2">Confirm Password</label><br />
                        <input type="password" id="newpassword2" name="newpassword2" class="form-control" /><br />
                    </fieldset>
                    <input type="submit" id="submit" value="Log In" class="btn btn-success"  />
                    <input type="button" id="cancel" value="Cancel" class="btn btn-danger" />
                </form>
            </div><!--Div for Login end here-->
        </div><!--Div for second row End here-->
    </div><!--Div for container fluid end here-->
</body>
</html>