<?php
	if( isset($_COOKIE['id']))
	{
		setcookie('id','',time()-3600);
		setcookie('username','',time()-3600);
		
		//Redirect to any page
		$home_url = '';
		header('Location : '.$home_url);
	}
?>