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
		
		//If Password is too short
	    if(strlen($_POST['newPass1']) < 6 || !isset($_POST['newPass1'])) { header("Location: account.php?error=2"); }
		
		// Check that the 2 passwords match
		if(md5($_POST['newPass1']) != md5($_POST['newPass2'])) { header("Location: account.php?error=3"); }
		
		//Change the password
		$newdbPass = md5($_POST['newPass1']);
		 	
		// If editing self, Set New Cookie
		$userID = mysql_result(mysql_query("SELECT ID FROM users WHERE username = '$_COOKIE[ID_my_site]' LIMIT 1"),0);
		if($_POST['id'] == $userID) {
		$hour = time() + 3600; 
		setcookie(Key_my_site, $newdbPass, $hour);
		}

		//Set new password in the database
		$changePass = mysql_query("UPDATE users SET password ='$newdbPass' WHERE ID = '$_POST[id]' LIMIT 1") or die(mysql_error());
		if(!$changePass) {
		  //If random error occurs, show random error page
		  header("Location: editUser.php?error=4&id={$_POST[id]}");		 
		 } else { 
		  header("Location: editUser.php?msg=1&id={$_POST[id]}");
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