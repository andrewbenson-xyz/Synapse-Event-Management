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

	//Convert Time to UNIX Time
	$timeFromUnix = strtotime($_POST["timeFrom"]);
	$timeToUnix = strtotime($_POST["timeTo"]);
	$insertQuery = mysql_query("UPDATE events SET name='".$_POST['name']."', timefrom='".$timeFromUnix."', timeto='".$timeToUnix."', phone='".$_POST['phone']."', price='".$_POST['price']."', dj='".$_POST['dj']."', dj2='".$_POST['dj2']."', details='".$_POST['details']."', location='".$_POST['location']."' WHERE ID='".$_POST['id']."' LIMIT 1");
	
	
	//If Error in SQL Query
	if(!$insertQuery) { 
	 die("Error: " . mysql_error()); 
	} else { 
	 header("Location: editEvent.php?msg=1");
	}
	//Email Assigned DJ
	//$djEmail = mysql_result(mysql_query("SELECT email FROM users WHERE ID = '$_POST[dj]' LIMIT 1"),0) or die("Error: " . mysql_error());
	//mail($djEmail, "New Event Information", "This is an email with information regarding your new gig.");
	

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