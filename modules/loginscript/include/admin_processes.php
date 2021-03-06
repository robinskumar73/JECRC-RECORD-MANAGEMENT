<?
error_reporting (E_ERROR | 0);
include_once '../include/constants.php';
include_once '../include/mail.php';

class Admin_Process {

	function check_status($page) {

		ini_set("session.gc_maxlifetime", Session_Lifetime); 
		session_start();
		if($_SESSION['admin'] != 1){
			header("Location: http://".$_SERVER['HTTP_HOST'].Script_Path."index.php?page=".$page); 
		}
	}


	function connect_db() {
		$conn_str = mysql_connect(DBHOST, DBUSER, DBPASS);
		mysql_select_db(DBNAME, $conn_str) or die ('Could not select Database.');
	}

	function query($sql) {

		$this->connect_db();
		$sql = mysql_query($sql);
		$num_rows = mysql_num_rows($sql);
		$result = mysql_fetch_assoc($sql);
			
	return array("num_rows"=>$num_rows,"result"=>$result,"sql"=>$sql);
	
	}
	
	function Register($post, $process) {

		if(isset($process)) {

		$pass1			= $post['pass1'];
		$pass2			= $post['pass2'];
		$username		= $post['username'];
		$email_address	= $post['email_address'];
		$first_name		= $post['first_name'];
		$last_name		= $post['last_name'];
		$info			= $post['info'];
		
		if((!$pass1) || (!$pass2) || (!$username) || (!$email_address) || (!$first_name) || (!$last_name) || (!$info)) {
		return "Some Fields Are Missing";
		}
		if ($pass1 !== $pass2) {
		return "Passwords do not match";
		}
		$query = $this->query("SELECT username FROM ".DBTBLE." WHERE username = '$username'");
		if($query['num_rows'] > 0){
		return "Username unavialable, please try a new username";
		}
		$query = $this->query("SELECT email_address FROM ".DBTBLE." WHERE email_address = '$email_address'");
		if($query['num_rows'] > 0){
		return "Emails address registered to another account.";
		}

		$this->query("INSERT INTO ".DBTBLE." (first_name, last_name, email_address, username, password, info) VALUES ('$first_name', '$last_name', '$email_address', '$username', '".md5($pass1)."', '".htmlspecialchars($info)."')");
			
		return 'User was created.';
	}
	}
	
	function active_users_table() {
   
   $sql = $this->query("SELECT * FROM ".DBTBLE." WHERE status = 'live'");
   $result = $sql['sql'];
   $num_rows = $sql['num_rows'];
   $this->create_table($result, $num_rows);

	}

	function suspended_users_table() {
   
   $sql = $this->query("SELECT * FROM ".DBTBLE." WHERE status = 'suspended'");
   $result = $sql['sql'];
   $num_rows = $sql['num_rows'];
   $this->create_table($result, $num_rows);

	}
	
	function pending_users_table() {
   
   $sql = $this->query("SELECT * FROM ".DBTBLE." WHERE status = 'pending'");
   $result = $sql['sql'];
   $num_rows = $sql['num_rows'];
   $this->create_table($result, $num_rows);

	}

	function create_table($result, $num_rows) {
		
	   echo "<table  align=\"center\" border=\"1\" cellspacing=\"0\" cellpadding=\"5\" class=\"admin_tabel table table-striped\">\n"; 
	   echo "<tr class=\"tabel_header\">
	  		 <th align=\"center\" width=\"25%\"><strong> Name:</strong></th>
	  		 <th align=\"center\" width=\"15%\"><strong> Email Address:</strong></th>
	  		 <th align=\"center\" width=\"15%\"><strong> Username:</strong></th>
	  		 <th align=\"center\" width=\"15%\"><strong> Info:</strong></th>
	  		 <th align=\"center\" width=\"10%\"><strong> Login:</strong></th>
	  		 <th align=\"center\" width=\"5%\"><strong> Level:</strong></th>
	  		 <th align=\"center\" width=\"10%\" colspan=\"3\">Action</th>
	  		 </tr>\n";   
	   
	   for($i=0; $i<$num_rows; $i++){
	$userid=mysql_result($result,$i,"userid");
	
	$name=ucwords(substr(mysql_result($result,$i,"first_name")." ".mysql_result($result,$i,"last_name"),0,30));
	$email_address=ucwords(substr(mysql_result($result,$i,"email_address"),0,16));
	$info=ucwords(substr(mysql_result($result,$i,"info"),0,16));
	$username=ucwords(substr(mysql_result($result,$i,"username"),0,16));
	
	$userlevel=mysql_result($result,$i,"user_level");
	$last_loggedin=mysql_result($result,$i,"last_loggedin");
	
	echo "<tr height=\"35\">
   		  <td> $name</td>
   		  <td> $email_address</td>
    	  <td> $username</td>
    	  <td> $info</td>
    	  <td align=\"center\"> $last_loggedin</td>
    	  <td align=\"center\"> $userlevel</td>
    	  <td align=\"center\"> <a href=\"admin_edituser.php?userid=$userid\"><img src=\"../include/icons/edit.png\" alt=\"Edit Users Details\" /></a></td>
    	  <td align=\"center\"> <a href=\"admin_editpass.php?userid=$userid\"><img src=\"../include/icons/password.png\" alt=\"Change Users Password\" /></a></td>
    	  <td align=\"center\"> <a href=\"admin_deleteuser.php?id=$userid\"><img src=\"../include/icons/delete.png\" alt=\"Delete User\" /></a></td>
		  </tr>\n";     
	}

	if($num_rows == 0) {
	
	echo "<tr height=\"35\">
	 	  <td colspan=\"9\" align=\"center\">No Members to Display</td>
    	  </tr>\n";
	}
	
	echo "</table><br>\n";
	
	}



function list_users() {

	   $q = "SELECT * FROM ".DBTBLE."";
	   $result = mysql_query($q);
	   $num_rows = mysql_numrows($result);

	echo "<select name=\"username\">";	

	for($i=0; $i<$num_rows; $i++){
		
		$name=mysql_result($result,$i,"username");
		echo "<option value=\"$name\">$name</option>"; 
	
	}
	
	echo "</select>";
	
	}
	
	function update_user($POST, $change) {

	if(isset($change)) {
	
	$username = $POST['username'];
	$level = $POST['level'];
	
		$this->query("UPDATE ".DBTBLE." SET user_level = '$level' WHERE username = '$username'");
	
 		return  $username."'s User level was changed to ".$level;
	
	}	
	}

	function suspend_user($POST, $suspend) {
	
	if(isset($suspend)) {
	
	$username = $POST['username'];
	$status = $POST['level'];
	$email = $this->query("SELECT email_address FROM ".DBTBLE." WHERE username = '$username'");
	
		$this->query("UPDATE ".DBTBLE." SET status = '$status' WHERE username = '$username'");
	
		if ($status == "live") {
 		 return  $username."'s User Ststus was changed to Live.";
			Status_Changed($username, $email, 'Approved');
	
		} else if ($status == "suspended") {
 		 return  $username."'s User Ststus was changed to Suspended.";
			Status_Changed($username, $email, 'Suspended');
		}
	}
	}

	function delete_user($_POST, $delete) {
	
	if(isset($delete)) {
	
		$check = $_POST['check'];
		$id = $_POST['id'];
		
	if ($check == "yes") {	
 
	$this->query("DELETE FROM ".DBTBLE." WHERE userid = $id");

		return  "User was deleted.<br /><a href=\"admin_center.php\">Admin Center</a>";

	} else if ($check == "no") {
	
		return  "User was not deleted.<br /><a href=\"admin_center.php\">Admin Center</a>";
	
	}
	
	} else {
		return "Are you sure you want to delete the user?";
	}
	}
	

	function edit_user($_POST, $edit) {
	
	if(isset($edit)) {
	
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$info = $_POST['info'];
	$email_address = $_POST['email_address'];
	$username = $_POST['username'];
	$userid = $_POST['userid'];
	
	
	$this->query("UPDATE ".DBTBLE." SET first_name='$first_name', last_name='$last_name', email_address='$email_address', info='$info', username='$username' WHERE userid='".$userid."'");

	return "User Details Updated.<br /><a href=\"admin_center.php\">Admin Center</a>";

	}
	}
	
	function edit_request($edit) {
	
	if(isset($edit)) {
	$details = $this->query('SELECT * FROM '.DBTBLE.' WHERE userid = '.$_GET['userid'].'');
		return $details['result'];
	} else {
	$details = $this->query('SELECT * FROM '.DBTBLE.' WHERE userid = '.$_GET['userid'].'');
		return $details['result'];
	}
	
	}

	function edit_pass($_POST, $edit) {

	if(isset($edit)) {

	$pass1 = $_POST['pass1'];
	$pass2 = $_POST['pass2'];
	$userid = $_POST['userid'];
	
	if ($pass1 !== $pass2) {
	return "Passwords do not match.";
	}
	
	$this->query("UPDATE ".DBTBLE." SET password = '".md5($pass1)."' WHERE userid = '$userid'");

		return "User password was updated.<br /><a href=\"admin_center.php\">Admin Center</a>";
	
	}
	}
}

?>