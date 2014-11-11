<?php
$to = "ravigupta9363@gmail.com, robinskumar73@gmail.com";
$subject = "automatic HTML email";

$message = "
<html>
<head>
<title>Ravi Gupta</title>
</head>
<body>
<p>Automatic mail send by localhost..!</p>
<table>
<tr>
<th>Firstname</th>
<th>Lastname</th>
</tr>
<tr>
<td>Robins</td>
<td>Gupta</td>
</tr>
</table>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <robinskumar73@gmail.com>' . "\r\n";


mail($to,$subject,$message,$headers);
?>