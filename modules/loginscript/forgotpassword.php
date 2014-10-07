<?php
include 'include/mail.php';
include 'include/constants.php';
include_once 'include/processes.php';
$Login_Process = new Login_Process;
$Check = $Login_Process->Forgot_Password($_GET, $_POST);
$Request = $Login_Process->Request_Password($_POST, $_POST['Request']);
$Reset = $Login_Process->Reset_Password($_POST, $_POST['Reset']);
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Password Reset</title>
<link href="../../static/bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet">
<link href="../../static/customstyle/mystyle.css" type="text/css" rel="stylesheet">
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




<?php 
switch($Check) {
	case "<!-- !-->":
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

<div class="right" style="margin-top:-8px; margin-right:-6px;"><a href="main.php">Log In</a></div>
<h1>Reset Password</h1>

<div class="red bg-danger"><?php  echo $Check.$Reset; ?></div>
<br />

<div class="label">New Password:</div>
<input name="pass1" type="password" placeholder="Password" class="field form-control"/>

<div class="label">Confirm New:</div>
<input name="pass2" type="password" placeholder="Confirm Password" class="field form-control"/>

<div class="right">
<input name="username" type="hidden" id="username" class="field form-control" value="<? echo $_GET['username']; ?>" />
<input name="code" type="hidden" id="code" class="field form-control" value="<? echo $_GET['code']; ?>" />
<input name="Reset" type="submit" class="button btn btn-success"  value="Reset Password" id="Reset"/>
</div>

</form>
<?php 
		break;
	default:
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

<div class="right" style="margin-top:-8px; margin-right:-6px;"><a href="../login.php">Log In</a></div>
<h1>Request Password Reset</h1>
<br />
<div class="red bg-danger"><?php  echo $Check.$Request; ?></div>


<div class="label">Email Address:</div>
<input name="email" type="text" class="field form-control" placeholder="Email" id="email" />

<div class="label">Username:</div>
<input name="username" type="text" class="field form-control" placeholder="Username" id="username" />

<br />

<div class="right">
  <input name="Request" type="submit" class="button btn btn-success" value="Request Reset Email" id="Request"/>        </td>
</div>

</form>
<?php 
}
?>


       
            </div><!--Div for Login end here-->
        </div><!--Div for second row End here-->
    </div><!--Div for container fluid end here-->
</body>

</html>