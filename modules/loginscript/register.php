<?
include_once 'include/processes.php';
$Login_Process = new Login_Process;
$New = $Login_Process->Register($_POST, $_POST['process']);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>JECRC - Login Script</title>
<link href="include/style.css" rel="stylesheet" type="text/css">
<body>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

<div class="right" style="margin-top:-8px; margin-right:-6px;"><a href="main.php">Log In</a></div>
<h1>Register</h1>
<div class="red">
<?php  echo $New; ?>
</div>

<div class="label">First Name:</div>
<input name="first_name" type="text" class="field" value="<? echo $_POST['first_name']; ?>" />

<div class="label">Last Name:</div>
<input name="last_name" type="text" class="field" value="<? echo $_POST['last_name']; ?>" />

<div class="label">Email Address:</div>
<input name="email_address" type="text" class="field" value="<? echo $_POST['email_address']; ?>" />

<div class="label">Department ID:</div>
<input name="department_id" type="text" class="field" value="<? echo $_POST['department_id']; ?>" />

<br /><br />
<div class="label">Password:</div>
<input name="pass1" type="password" class="field"/>

<div class="label">Repeat Password:</div>
<input name="pass2" type="password" class="field"/>

<br /><br />
<div class="label">Username:</div>
<input name="username" type="text" class="field" value="<? echo $_POST['username']; ?>" />

<div class="right">
  <input name="process" type="submit" id="process" value="Register"/>
</div>

</form>