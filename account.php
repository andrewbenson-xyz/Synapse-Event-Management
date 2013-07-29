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


$pageTitle = "Account";
include_once("header.php"); ?>




<!--Change Password-->
  <div class="box one_half">
   <div class="header">
    <h2>Edit Account</h2>
    <!--Toggle--> 
    <span class="toggle"></span> </div>
   <div class="content padding"> 
    <!--Form Elements-->

       <?php 
         // IF Old password is incorrect, show message
         if($_GET['error'] == "1") { 		
		 echo "
         <p class=\"message invalid\">
		 Your Old Password Was Incorrect
		 <span class=\"close\">X</span>
         </p>
         "; }
         // If password is too short, show message
         if($_GET['error'] == "2") { 		
		 echo "
         <p class=\"message invalid\">
		 Your New Password Must Be 6 Or More Characters
		 <span class=\"close\">X</span>
         </p>
         "; }
		 //If passwords do not match, show message
		 if($_GET['error'] == "3") { 		
		 echo "
         <p class=\"message invalid\">
		 Your Passwords Do Not Match
		 <span class=\"close\">X</span>
         </p>
         "; }
         //If Other Error Occurs
		 if($_GET['error'] == "4") { 		
		 echo "
         <p class=\"message invalid\">
		 An error occurred. Please try again later.
		 <span class=\"close\">X</span>
         </p>
         "; }
         // if password change was success, show message
         if($_GET['msg'] == "1") { 		
		 echo "
         <p class=\"message valid\">
		 Your Password Has Been Changed
		 <span class=\"close\">X</span>
         </p>
         "; }

         ?>
         
<form method="post" action="processChangePassword.php">
     <fieldset>
      <legend>Change Password</legend>
      <div class="field">
       <label>Old Password</label>
       <input type="password" name="oldPass" />
      </div>
      <div class="field">
       <label>New Password</label>
       <input type="password" name="newPass1"/>
      </div>  
      <div class="field">
       <label>Confirm New Password</label>
       <input type="password" name="newPass2" />
      </div>   
      <button>Submit</button>
     </fieldset>
    </form>
   </div>
  </div>
  <!--View Account-->
  <div class="box one_half last">
   <div class="header">
   <h2>Account Information</h2>
   <!--Toggle--> 
    <span class="toggle"></span> 
   </div>
    <div class="content padding"> 
      <fieldset>
      <div class="field">
		<b>Name:</b> <?php echo mysql_result(mysql_query("SELECT name FROM users WHERE username = '$_COOKIE[ID_my_site]' LIMIT 1"), 0); ?>
      </div>
      <div class="field">
		<b>Email:</b> <?php echo mysql_result(mysql_query("SELECT email FROM users WHERE username = '$_COOKIE[ID_my_site]' LIMIT 1"), 0); ?>
      </div>  
      <div class="field">
		<b>Phone:</b> <?php echo mysql_result(mysql_query("SELECT phone FROM users WHERE username = '$_COOKIE[ID_my_site]' LIMIT 1"), 0); ?>
      </div>  
      <div class="field">
		<b>Address:</b> <?php echo mysql_result(mysql_query("SELECT address FROM users WHERE username='{$_COOKIE['ID_my_site']}' LIMIT 1"),0); ?>
      </div> 
      <div class="field">
		<b>Position:</b> <?php echo mysql_result(mysql_query("SELECT position FROM users WHERE username = '$_COOKIE[ID_my_site]' LIMIT 1"), 0); ?>
      </div>  
     </fieldset> 
    </div>
   </div>
  </div>
 
  <!--Footer-->
  <div id="footer" class="separator"> 
   <!-- Remove this notice or replace it with whatever you want --> 
   &#169; Copyright 2011 - <?php echo date("Y"); ?> Andrew Benson &bull; <a href="#">Top</a> </div>
  <!--End .container--> 
 </div>
 <!--End #content--> 
</div>
</body>
</html>
<?php

 			} 

 		} 

 		} 

 else 

 

 //if the cookie does not exist, they are taken to the login screen 

 {			 

 header("Location: login.php"); 

 } 

 ?>