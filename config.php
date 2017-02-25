<?php

	define("DBSERVER", "localhost");
	define("DBUSERNAME", "root");
	define("DEPASSWORD", "");
	define("DBNAME", "appshop");
	$conn = mysqli_connect(DBSERVER,DBUSERNAME,DEPASSWORD,DBNAME);
	$conn->set_charset("utf8");

	if(!$conn){
		die("connect false:".mysqli_connect_errno());
	}


?>