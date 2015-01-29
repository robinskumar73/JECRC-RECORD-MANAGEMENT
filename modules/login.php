<?php
include_once 'loginscript/include/processes.php';
$Login_Process = new Login_Process;
$Login_Process->check_login($_GET['page']);
$Login = $Login_Process->log_in($_POST['user'], $_POST['pass'], $_POST['remember'], $_POST['page'], $_POST['submit']); 
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
            	<form method="post" action=" <?php echo $_SERVER['PHP_SELF']; ?>" role="form">
                	<fieldset>
                    	<legend>Log In</legend>
                        <br />
                        <div class="bg-danger red"> <?php echo $Login; ?> </div>
                        <br />
                        <label for="username">Username</label><br />
            			<input name="user" type="text" class="field form-control" id="user" /><br /> 																													                          
            			<label for="password">Password</label><br />
                        <input name="pass" type="password" class="field form-control" id="pass" value="" /><br />
                        
                    </fieldset>
                   
					<div class="center">
						<a href="/Manage/modules/loginscript/forgotpassword.php">Password Recovery</a> | <a href="/Manage/modules/loginscript/register.php">Sign Up</a>
					</div>
                     <br />
                    <div class="right">
						<label>Remember Me
							<input name="remember" type="checkbox" value="true" />
						</label>
					</div>
                    <br />
                    <input name="page" type="hidden" value="<? echo $_GET['page']; ?>" />
					<input name="submit" type="submit" id="submit" class="button btn btn-success" value="Log In" />
                    
                </form>
            </div><!--Div for Login end here-->
        </div><!--Div for second row End here-->
    </div><!--Div for container fluid end here-->
</body>

</html>