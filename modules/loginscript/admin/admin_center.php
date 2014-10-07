<?
include_once '../include/admin_processes.php';
$Admin_Process = new Admin_Process;
$Admin_Process->check_status($_SERVER['SCRIPT_NAME']);
$New = $Admin_Process->Register($_POST, $_POST['add_user']);
$Suspend = $Admin_Process->suspend_user($_POST, $_POST['Suspend']);
$Change = $Admin_Process->update_user($_POST, $_POST['Change']);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>JECRC ADMIN CENTER</title>
<link href="../../../static/bootstrap/css/bootstrap.min.css" type="text/css" />

<body>
<h1>Admin Center: <? echo $_SESSION['username']; ?><br />
</h1>

<div align="center"><a href="../../../index.php">Return to Main</a></div>
<div class="bg-danger" align="center">
<?php  echo $_GET['alert']; ?></div>

<br />

<div align="center" class="table-responsive">
<h1>
<a name="active" id="active"></a>		Active Users </h1>
<?	$Admin_Process->active_users_table()  ?>
</div><br>

<div align="center">
<h1> <a name="suspended" id="suspended"></a> Suspended Users </h1>
<?	$Admin_Process->suspended_users_table()  ?>
</div><br>

<?php 
if(Admin_Approvial == true) {
echo '
<div align="center">
<h1> <a name="pending" id="pending"></a> Users Awating Approval </h1>';
$Admin_Process->pending_users_table();
echo '</div><br>';
}
?>

<div style="width:600px; margin:0 auto; margin-bottom:20px;">

<a name="add" id="add"></a>
<form action="<?php echo $_SERVER['PHP_SELF']."#add"; ?>" method="post" style="float:left; margin-top:0px;">
<h1> Add User</h1>

<div class="red"><?php echo $New; ?></div>

<div class="label">First Name:</div>
<input name="first_name" type="text" class="field" value="<? echo $_POST['first_name']; ?>" />
<br />

<div class="label">Last Name:</div>
<input name="last_name" type="text" class="field" value="<? echo $_POST['last_name']; ?>" />
<br />

<div class="label">Email Address:</div>
<input name="email_address" type="text" class="field" value="<? echo $_POST['email_address']; ?>" />
<br />

<div class="label">Information:</div>
<input name="info" type="text" class="field" value="<? echo $_POST['info']; ?>" />
<br />
<br />

<div class="label">Password:</div>
<input name="pass1" type="password" class="field"/>
<br />

<div class="label">Repeat Password:</div>
<input name="pass2" type="password" class="field"/>
<br />
<br />

<div class="label">Username:</div>
<input name="username" type="text" class="field" value="<? echo $_POST['username']; ?>" />
<br />


<div class="right">
		<input name="add_user" type="submit" id="add_user" value="Add User" />
</div>

</form><br>
<a name="change" id="change"></a>
<form action="<?php echo $_SERVER['PHP_SELF']."#change"; ?>" method="post" style="float:right; margin-top:0px;">

<h1> Change User Level</h1>
<div class="red"><?php echo $Change; ?> </div>
<div class="label">Username Name:</div>
<?php $Admin_Process->list_users() ?><br><br>
<div class="label">Username Level:</div>

<select name="level" id="level">
                                  <option value="1">1</option>
                                  <option value="2">2</option>
                                  <option value="3">3</option>
                                  <option value="4">4</option>
                                  <option value="5">5</option>
                                </select>

<div class="right">
<input name="Change" type="submit" class="textfield" value="Update" />
</div>

</form>
<br>
<a name="suspend" id="suspend"></a>
<form action="<?php echo $_SERVER['PHP_SELF']."#suspend"; ?>" method="post" style="float:right; margin-top:20px;">
<h1> Suspend User</h1>
<div class="red"><?php echo $Suspend; ?> </div>
<div class="label">Username Name:</div>
<?php $Admin_Process->list_users() ?><br><br>

<div class="label">Status</div>
<select name="level" id="level">
                                  <option value="suspended">Suspended</option>
                                  <option value="live">Live</option>
                                </select>


<div class="right">
<input name="Suspend" type="submit" class="textfield" value="Update" />
</div>

</form>
</div>