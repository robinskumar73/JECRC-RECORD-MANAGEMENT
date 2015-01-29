<?php
include '../../database_connection.php';

# Databse Infomation

// Database Server (localhost)
define("DBHOST",'localhost');
// Database Username
define("DBUSER",'root'); 
// Database Password
define("DBPASS",'');                           
// Database Name
define("DBNAME",'attendance');                     
// Database Tabel
define("DBTBLE","faculty");                          

# Location Infomation

// Path of script with trailing slashes
define("Script_Path","/Manage/");
// URL of script (no trailing slash)
define("Script_URL","http://localhost");

# System Infomation

// System Name
define("Site_Name","JECRC RECORD MANAGEMENT");                       
// Name on system emails
define("Email_From","JECRC MAIL");                        
// Webmaster email address
define("Email_Address","services@jecrc.ac.in");          
// Dont reply email address
define("Non_Reply","services@jecrc.ac.in");              

# Session and Cookie Infomation

// Session Lifetimr in Seconds
define("Session_Lifetime", 60*60);              
// Cookie names
define("CKIEUS","USERNAME");              
define("CKIEPS","PASSWORDMD5");              

# System Settings
// Require admin approvial for new users
define("Admin_Approvial", false); // true or false

?>
