<?
include_once '../include/admin_processes.php';
$Admin_Process = new Admin_Process;
$Admin_Process->check_status($_SERVER['SCRIPT_NAME']);
//$delete = $Admin_Process->delete_user($_POST, $_POST['delete']);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Crisp Webdesign - Login Script</title>
<link href="../include/style.css" rel="stylesheet" type="text/css">
<body>

<form id="form1" name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']."?id=".$_GET['id']; ?>">
<h1>Delete User : <? echo $_GET['id']; ?></h1>

<div class="red"><? echo $delete; ?></div>
<br /> 
<br />
<div class="label">Yes</div>
<input name="check" type="radio" value="yes" /><br>

<div class="label">No</div>
<input name="check" type="radio" value="no" />

<div class="right">
<input name="id" type="hidden" class="textfield" id="textfield" value="<? echo $_GET['id']; ?> " />
<input name="delete" type="submit" class="textfield" id="delet" value="Continue &raquo;" />
</div>
</form>