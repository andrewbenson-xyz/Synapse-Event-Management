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

	$unixTimestamp = time();
	$UID = mysql_result(mysql_query("SELECT ID FROM users WHERE username = '$_COOKIE[ID_my_site]' LIMIT 1"),0);
	$insertQuery = mysql_query("INSERT INTO noticeboard (UID, notice, time) VALUES ('$UID', '$_POST[notice]', '$unixTimestamp')");
	
	//If Error in SQL Query
	if(!$insertQuery) { die("Error: " . mysql_error()); } 
	
	// Email Everybody about new notice
	$djEmails = mysql_query("SELECT email FROM users ORDER BY ID ASC");
		if(mysql_num_rows($djEmails) != 0) {
		 $posterName = mysql_result(mysql_query("SELECT name FROM users WHERE ID = '$UID' LIMIT 1"),0);
		 while($row = mysql_fetch_array($djEmails)) { 
		 $emailContent = stripslashes("A new notice has been added to the staff notice board on Synapse by " . $posterName . ". \n ===================\n" . addslashes($_POST['notice']) .  "\n =================== \nRegards, \nThe Synapse Staff");
		 mail($row['email'], "New Synapse Notice", $emailContent, "From: notify@synapse.djandrewbenson.com");
		 }
		}	
	
	//If Successful
	echo "<h1>Notice Posted Successfully</h1>";
	echo "<meta http-equiv=\"refresh\" content=\"1;url=/index.php\"> ";


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