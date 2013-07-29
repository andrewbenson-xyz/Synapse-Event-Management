<?php 
error_reporting(0);
//Connect to MySQL
include_once("mysqlCon.php"); 

 //Checks if there is a login cookie

 if(isset($_COOKIE['ID_my_site']))


 //if there is, it logs you in and directes you to the members page

 { 
 	$username = $_COOKIE['ID_my_site']; 

 	$pass = $_COOKIE['Key_my_site'];

 	 	$check = mysql_query("SELECT * FROM users WHERE username = '$username'")or die(mysql_error());

 	while($info = mysql_fetch_array( $check )) 	

 		{

 		if ($pass != $info['password']) 

 			{

 			 			}

 		else

 			{

 			header("Location: index.php");



 			}

 		}

 }


 //if the login form is submitted 

 if (isset($_POST['submit'])) { // if form has been submitted



 // makes sure they filled it in

 	if(!$_POST['username'] | !$_POST['pass']) {

		echo "<meta http-equiv=\"refresh\" content=\"0;url=/login.php?error=field\"> ";

 	}

 	// checks it against the database



 	if (!get_magic_quotes_gpc()) {

 		$_POST['email'] = addslashes($_POST['email']);

 	}

 	$check = mysql_query("SELECT * FROM users WHERE username = '".$_POST['username']."'")or die(mysql_error());



 //Gives error if user dosen't exist

 $check2 = mysql_num_rows($check);

 if ($check2 == 0) {

		echo "<meta http-equiv=\"refresh\" content=\"0;url=/login.php?error=pass\"> ";

 				}

 while($info = mysql_fetch_array( $check )) 	

 {

 $_POST['pass'] = stripslashes($_POST['pass']);

 	$info['password'] = stripslashes($info['password']);

 	$_POST['pass'] = md5($_POST['pass']);



 //gives error if the password is wrong

 	if ($_POST['pass'] != $info['password']) {
		echo "<meta http-equiv=\"refresh\" content=\"0;url=/login.php?error=pass\"> ";
 	}
 	
 	else 

 { 

 
 // if login is ok then we add a cookie 

 	 	$_POST['username'] = stripslashes($_POST['username']); 
 	 	$hour = time() + 3600; 
 		setcookie(ID_my_site, $_POST['username'], $hour);
 		setcookie(Key_my_site, $_POST['pass'], $hour);	 
		// Add login to access logs
		$ipAddress = $_SERVER['REMOTE_ADDR'];
		$currentTime = time();
		$userID = mysql_result(mysql_query("SELECT ID FROM users WHERE username = '" . $_COOKIE['ID_my_site'] . "' LIMIT 1"),0);
		mysql_query("INSERT INTO logs (username, ipAddress, time) VALUES ('$userID','$ipAddress', '$currentTime')") or die(mysql_error()); 
 
 //then redirect them to the members area 
		echo "<meta http-equiv=\"refresh\" content=\"0;url=/index.php\"> ";

 } 

 } 

 } 

 else 

{	 

 

 // if they are not logged in 

 ?> 
 <!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Synapse - Login</title>
<!--CSS-->
<link rel="stylesheet" href="css/reset.css" type="text/css" />
<link rel="stylesheet" href="css/styles.css" type="text/css" />
<!-- Google Fonts -->
<link href='http://fonts.googleapis.com/css?family=Droid+Serif:regular,italic' rel='stylesheet' type='text/css' />
<link href='http://fonts.googleapis.com/css?family=Droid+Sans:regular,bold' rel='stylesheet' type='text/css' />
<!--Scripts-->
<!--jQuery-->
<script src="plugins/jquery/jquery.js" type="text/javascript"></script>
<!--jQuery Superfish-->
<script src="plugins/jquery-superfish/superfish.js" type="text/javascript"></script>
<!--jQuery Excanvas-->
<!--[if IE]><script src="plugins/jquery-excanvas/excanvas.js" type="text/javascript"></script><![endif]-->
<!--jQuery Visualize-->
<script src="plugins/jquery-visualize/visualize.jQuery.js" type="text/javascript"></script>
<link href="plugins/jquery-visualize/visualize.css" rel="stylesheet" type="text/css">
<!--jQuery Uniform-->
<script src="plugins/jquery-uniform/jquery.uniform.min.js" type="text/javascript"></script>
<link href="plugins/jquery-uniform/css/uniform.default.css" rel="stylesheet" type="text/css">
<!--jQuery Tipsy-->
<script src="plugins/jquery-tipsy/jquery.tipsy.js" type="text/javascript"></script>
<link href='plugins/jquery-tipsy/tipsy.css' rel='stylesheet' type='text/css' />
<!--jQuery Datatables-->
<script src="plugins/jquery-datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<!--jQuery Facebox-->
<script src="plugins/jquery-facebox/facebox.js" type="text/javascript"></script>
<link rel="stylesheet" href="plugins/jquery-facebox/facebox.css" type="text/css" />
<!--Script Loader-->
<script src="plugins/loader.js" type="text/javascript"></script>
</head>

<body>

<!--Content-->
<div id="content">
 <div id="login" class="container"> 
 <img class="logo" src="assets/logoLogin.png" alt="logo" />
 	<!--Login-->
 	<div class="box">
  	<div class="header">
   	<h2>Login</h2>
   </div>
   <div class="content">
    <div class="tabs"> 
     <!--tab1-->
     <div class="tab" id="tab1">
      <?php 
      if(isset($_GET['error']) && $_GET['error'] == "pass") {
		echo "
         <p class=\"message invalid\">
      	 Invalid username and/or password.
         <span class=\"close\">X</span>
         </p>
         "; }
       if(isset($_GET['error']) && $_GET['error'] == "field") {
		echo "
         <p class=\"message invalid\">
      	 You did not enter a required field. 
         <span class=\"close\">X</span>
         </p>
         "; }  
         ?>
         
      <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" class="form">
     <p class="field">
      <label for="username">Username </label>
      <input id="username" name="username" class="large">
     </p>
     <p class="field">
      <label for="password">Password </label>
      <input id="password" type="password" name="pass" class="large">
     </p>
     <p class="field">
     	<button type="submit" name="submit">Login</button>
     	<button type="reset" class="secondary">Reset</button>
     </p>
   </form>
     </div>
          
    <!--End .tabs-->
    </div>    	
   <!--End .content-->	
   </div>
  <!--End .box-->
  </div>
 <!--End .container-->
 </div>
  <!--End #content-->
</div>
</body>
</html>
 <?php 

 } 

 

 ?>