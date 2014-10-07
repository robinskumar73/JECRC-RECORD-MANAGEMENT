<?php

include_once 'loginscript/include/processes.php';
$Login_Process = new Login_Process;
$Login_Process->check_status($_SERVER['SCRIPT_NAME']);

?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>JECRC</title>
<link href="../static/bootstrap/css/bootstrap.min.css" type="text/css" rel="stylesheet">
<link href="../static/customstyle/mystyle.css" type="text/css" rel="stylesheet">
<link rel="icon" type="image/png" href="#" >
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!--Adjusting for Mobile View-->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

</head>

<body>