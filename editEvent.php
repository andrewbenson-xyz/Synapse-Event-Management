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


$pageTitle = "Events";
include_once("header.php"); ?>




<!--Change Password-->
  <div class="box one_half">
   <div class="header">
    <h2>Edit Event</h2>
    <!--Toggle--> 
    <span class="toggle"></span> </div>
   <div class="content padding"> 
    <!--Form Elements-->

       <?php 
         // if password change was success, show message
         if($_GET['msg'] == "1") { 		
		 echo "
         <p class=\"message valid\">
		 Changes Saved
		 <span class=\"close\">X</span>
         </p>
         "; }

		// Load Default Values
		$loadQuery = mysql_query("SELECT * FROM events WHERE ID = '".$_GET['id']."' LIMIT 1");
		while($value = mysql_fetch_array($loadQuery)) {
		       
		$timefrom = date("m/j/Y g:i A", $value['timefrom']);
        $timeto = date("m/j/Y g:i A", $value['timeto']);


         ?>
         
<form method="post" action="processEditEvent.php">
	<input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
     <fieldset>
      <legend>Change Event Information</legend>
      <div class="field">
       <label>Name</label>
       <input type="text" name="name" value="<?php echo $value['name']; ?>"/>
      </div>
      <div class="field">
       <label>Phone</label>
       <input type="text" name="phone" value="<?php echo $value['phone']; ?>"/>
      </div>
      <div class="field">
       <label>Price</label>
       <input type="text" name="price" value="<?php echo $value['price']; ?>"/>
      </div>
      <div class="field">
       <label>Time From</label>
       <input type="text" name="timeFrom" value="<?php echo $timefrom; ?>"/>
       <label>Time To</label>
       <input type="text" name="timeTo" value="<?php echo $timeto; ?>"/>
      </div>
      <div class="field">
       <label>Location</label>
       <input type="text" name="location" value="<?php echo $value['location']; ?>"/>
      </div>      
      <div class="field">
       <label>Details</label>
       <textarea rows="7" cols="50" name="details" ><?php echo $value['details']; ?></textarea>
      </div>      
	 <div class="field">
       <label>Assigned DJ</label>
		<?php
		$djQuery = mysql_query("SELECT * FROM users ORDER BY name ASC");
		if(mysql_num_rows($djQuery) == 0) { echo "No DJs Found."; }
		if(mysql_num_rows($djQuery) != 0) {
		 echo "<select name=\"dj\">\n";
		 while($row = mysql_fetch_array($djQuery)) { 
		  // Get Assigned DJ ID to event
		  $assignedDJ = mysql_result(mysql_query("SELECT dj FROM events WHERE ID = '".$_GET['id']."' LIMIT 1"),0);
		  if($row['ID'] == $assignedDJ) {
		    echo "<option value=\"{$row[ID]}\" selected>{$row[name]}</option>\n"; 
		  } else { 
		  echo "<option value=\"{$row[ID]}\">{$row[name]}</option>\n"; 
		  }
		 }
		 echo "</select>";
		}
		?>
      </div>
      <div class="field">
       <label>Secondary DJ</label>
		<?php
		$djQuery = mysql_query("SELECT * FROM users ORDER BY name ASC");
		if(mysql_num_rows($djQuery) == 0) { echo "No DJs Found."; }
		if(mysql_num_rows($djQuery) != 0) {
		 
		 echo "<select name=\"dj2\">";
		while($row = mysql_fetch_array($djQuery)) { 
		  // Get Assigned DJ ID to event
		  $assignedDJ2 = mysql_result(mysql_query("SELECT dj2 FROM events WHERE ID = '".$_GET['id']."' LIMIT 1"),0);
		  if($assignedDJ2 == 0) { $selected2 = " selected"; }
		  echo "<option value=\"0\" {$selected2}>-No Secondary DJ-</option>";
		  if($row['ID'] == $assignedDJ2) {
		    echo "<option value=\"{$row[ID]}\" selected>{$row[name]}</option>\n"; 
		  } else { 
		  echo "<option value=\"{$row[ID]}\">{$row[name]}</option>\n"; 
		  }
		 }
		 echo "</select>";
		}
		?>
      </div>
      <button>Submit</button>
     </fieldset>
    </form>
   </div>
  </div>
   <?php } ?>
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