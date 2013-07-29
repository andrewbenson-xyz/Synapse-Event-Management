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


$pageTitle = "Directory";
include_once("header.php"); ?>
  <!--Table-->
  <div class="box"> 
   <!--Title-->
   <div class="header">
    <h2><a href="#">Employee Directory</a></h2>
    <!--Toggle--> 
    <span class="toggle"></span> </div>
   <!--Content-->
   <div class="content clearfix"> 
    <!--Table-->
    <table class="datatable">
     <thead>
      <tr>
       <th class="sorting_asc"> Name </th>
       <th class="sorting"> Position </th>
       <th class="sorting"> Phone </th>
       <th class="sorting"> Email </th>
      </tr>
     </thead>
     <tbody>
     <?php 
     $userQuery = "SELECT * FROM users WHERE active='1' ORDER BY name DESC";
     $userQueryResult = mysql_query($userQuery)or die(mysql_error());
     $even_odd = ( ' odd' != $even_odd ) ? ' odd' : ' even';
     if(mysql_num_rows($userQueryResult) != 0) {
      while ($row = mysql_fetch_array($userQueryResult)) {
       echo "
	   <tr class=\"gradeA {$even_odd}\">
       <td class=\" sorting_1\">{$row['name']}</td>
       <td>{$row['position']}</td>
       <td>{$row['phone']}</td>
       <td>{$row['email']}</td>
       </tr>";

	}
    	
     }
     ?>
           </tbody>
    </table>
   </div>
  </div>
  <!--Footer-->
  <div id="footer" class="separator"> 
   <!-- Remove this notice or replace it with whatever you want --> 
   &#169; Copyright 2011 - <?php echo date("Y"); ?>  Andrew Benson &bull; <a href="#">Top</a> </div>
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