<?php 
include_once("mysqlCon.php");
 //checks cookies to make sure they are logged in 

 if(isset($_COOKIE['ID_my_site'])) 

 { 

 	$username = $_COOKIE['ID_my_site']; 

 	$pass = $_COOKIE['Key_my_site']; 

 	 	$check = mysql_query("SELECT * FROM users WHERE username = '$username'")or die(mysql_error()); 

 	while($info = mysql_fetch_array( $check )) 	 

 		{ 

 

 //if the cookie has the wrong password, they are taken to the login page 

 		if ($pass != $info['password']) 

 			{ 			header("Location: login.php"); 

 			} 

 

 //otherwise they are shown the admin area	 

 	else 

 			{
 //Begin Page Content			
		
	$insertQuery = mysql_query("UPDATE users SET name='".$_POST['name']."', email='".$_POST['email']."', phone='".$_POST['phone']."', address='".$_POST['address']."', position='".$_POST['position']." WHERE ID = '".$_POST['id']."' LIMIT 1");
		if(!$insertQuery) {
		 header("Location: editUser.php?id={$_POST[id]}&error=5");
		} else {
		 header("Location: editUser.php?id={$_POST[id]}&msg=2");
		}

 
 	

 // End Page Content
 			} 

 		} 

 		} 

 else 

 

 //if the cookie does not exist, they are taken to the login screen 

 {			 

 header("Location: login.php"); 

 } 

 ?>