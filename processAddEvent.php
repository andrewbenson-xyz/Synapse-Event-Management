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
 
 
	$pageTitle = "Dashboard";
	include_once("header.php");

	//Convert Time to UNIX Time
	$timeFromUnix = strtotime($_POST["timeFrom"]);
	$timeToUnix = strtotime($_POST["timeTo"]);
	$addedBy = mysql_result(mysql_query("SELECT name FROM users WHERE username = '$_COOKIE[ID_my_site]' LIMIT 1"),0);
	$details = $_POST['details'] . " Booked on " . date("n/j/Y") . " by " . $addedBy . ".";

	$insertQuery = mysql_query("INSERT INTO events (name, timefrom, timeto, phone, email, price, dj, dj2, details, location) VALUES ('$_POST[name]', 	'$timeFromUnix', '$timeToUnix', '$_POST[phone]', '$_POST[email]', '$_POST[price]', '$_POST[dj]', '$_POST[dj2]', '$details', '$_POST[location]' )");
	
	//If Error in SQL Query
	if(!$insertQuery) { die("Error: " . mysql_error()); } 
	
	//If Successful
	echo "<h1>Event Added Successfully</h1>";
	echo "<meta http-equiv=\"refresh\" content=\"1;url=/index.php\"> ";

	//Email Assigned DJ
	$djEmail = mysql_result(mysql_query("SELECT email FROM users WHERE ID = '$_POST[dj]' LIMIT 1"),0) or die("Error: " . mysql_error());
	$emailSubject = "Synapse - New Event Information";
	$emailContent .= "You now have an event assigned to you.";
	mail($djEmail, $emailSubject, $emailContent);
	

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