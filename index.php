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

$pageTitle = "Dashboard";
include_once("header.php"); ?>
  <!--Table-->
  <div class="box"> 
   <!--Title-->
   <div class="header">
    <h2><a href="#">Upcoming Events</a></h2>
    <!--Toggle--> 
    <span class="toggle"></span> </div>
   <!--Content-->
   <div class="content clearfix"> 
    <!--Table-->
    <table class="datatable">
     <thead>
      <tr>
       <th class="sorting_asc"> Event Date </th>
       <th class="sorting"> Name </th>
       <th class="sorting"> Location </th>
       <th class="sorting"> Price </th>
       <th class="sorting"> DJ </th>
       <th class="sorting"> Time </th>
       <th class="sorting"> Phone </th>       
       <th class="sorting"> Details </th>
      </tr>
     </thead>
     <tbody>
     <?php 
     $upcoming = strtotime("today");
     $eventQuery = "SELECT * FROM events WHERE complete='0' AND timeto > '$upcoming' ORDER BY timefrom DESC";
     $eventQueryResult = mysql_query($eventQuery)or die(mysql_error());
     //if(mysql_num_rows($eventQueryResult) == 0) { echo "No Results Found."; }
     $even_odd = ( ' odd' != $even_odd ) ? ' odd' : ' even';
     if(mysql_num_rows($eventQueryResult) != 0) {
      while ($row = mysql_fetch_array($eventQueryResult)) {
       $djName = mysql_result(mysql_query("SELECT name FROM users WHERE ID='{$row['dj']}' LIMIT 1"),0);
       if($row['dj2'] != 0) {
        $dj2Name =  " & " . mysql_result(mysql_query("SELECT name FROM users WHERE ID='{$row['dj2']}' LIMIT 1"),0);
       } else {
       	$dj2Name = null;
       }
       $date = date("l, F j, Y", $row['timefrom']);
       $timefrom = date("g:i A", $row['timefrom']);
       $timeto = date("g:i A", $row['timeto']);
       //Trim Details
       $details  = substr($row['details'], 0, 35);
       // Add Elipsis if too large
       if(strlen($row['details']) > 35) {$details = $details . "…"; }
       
	   // Get DJ Address
       $djAddress = mysql_result(mysql_query("SELECT address FROM users WHERE username='{$_COOKIE['ID_my_site']}' LIMIT 1"),0);

       echo "
	   <tr class=\"gradeA {$even_odd}\">
       <td class=\" sorting_1\">{$date}</td>
       <td>{$row['name']}</td>
       <td><a href=\"http://maps.google.com/maps?t=m&daddr={$row['location']}&saddr={$djAddress}\" target=\"_blank\">{$row['location']}</td>
       <td>\${$row['price']}</td>
       <td>{$djName} {$dj2Name}</td>
       <td>{$timefrom} - {$timeto}</td>
       <td>{$row['phone']}</td>
       <td>{$details}</td>
      </tr>";

	}
    	
     }
     ?>
           </tbody>
    </table>
   </div>
  </div>
  <!--Forms-->
  <div class="box one_half">
   <div class="header">
    <h2>Add Event</h2>
    <!--Toggle--> 
    <span class="toggle"></span> </div>
   <div class="content padding"> 
    <!--Form Elements-->
    <form method="post" action="processAddEvent.php">
     <fieldset>
      <legend>New Event</legend>
      <div class="field">
       <label>Name</label>
       <input type="text" name="name" />
      </div>
      <div class="field">
       <label>Time From</label>
       <input type="text" name="timeFrom" />
       <label>Time To</label>
       <input type="text" name="timeTo" />
      </div>
      <div class="field">
       <label>Phone Number</label>
       <input type="text" name="phone"/>
      </div>  
      <div class="field">
       <label>Email</label>
       <input type="text" name="email"/>
      </div>        
      <div class="field">
       <label>Location</label>
       <input type="text" name="location" />
      </div>   
      <div class="field">
       <label>Price</label>
       $<input type="text" name="price" />
      </div>
      <div class="field">
       <label>Event Details</label>
       <textarea rows="7" cols="50" name="details" ></textarea>
      </div>
      <div class="field">
       <label>Assigned DJ</label>
		<?php
		$djQuery = mysql_query("SELECT * FROM users ORDER BY name ASC");
		if(mysql_num_rows($djQuery) == 0) { echo "No DJs Found."; }
		if(mysql_num_rows($djQuery) != 0) {
		 echo "<select name=\"dj\">";
		 while($row = mysql_fetch_array($djQuery)) { echo "<option value=\"{$row[ID]}\">{$row[name]}</option>"; }
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
		 echo "<option value=\"0\">-No Secondary DJ-</option>";
		 while($row = mysql_fetch_array($djQuery)) { echo "<option value=\"{$row[ID]}\">{$row[name]}</option>"; }
		 echo "</select>";
		}
		?>
      </div>      
      <button>Submit</button>
     </fieldset>
    </form>
   </div>
  </div>
  <?php 
     $usrPermissions = mysql_query("SELECT permissions FROM users WHERE username = '$_COOKIE[ID_my_site]' LIMIT 1");
     if(mysql_result($usrPermissions, 0) > 1) { 
       ?>

      <!--Statistics-->
        <div class="box one_half last">
         <div class="header">
          <h2>Statistics</h2>
          <!--Toggle--> 
          <span class="toggle"></span> 
         </div>
         <div class="content padding"> 
      	 <?php 
      	 // Events This Year
      	 $currentYear = strtotime("Jan 1 0:01 EST This Year");
      	 $nextYear = strtotime("Dec 31 23:59 This Year")+1;
      	 $yearEvents = mysql_num_rows(mysql_query("SELECT * FROM events WHERE timefrom BETWEEN '".$currentYear."' AND '".$nextYear."'"));
      	 echo "<h4>Events Booked This Year: " . $yearEvents . "</h4>";
         // Events This Month
      	 $currentMonth = strtotime(date("01 M Y"), -5);
      	 $nextMonth = strtotime(date("31 M Y"), -5)+86400;
      	 $monthEvents = mysql_num_rows(mysql_query("SELECT * FROM events WHERE timefrom BETWEEN '".$currentMonth."' AND '".$nextMonth."'"));
      	 echo "<h4>Events Booked This Month: " . $monthEvents . "</h4>";
		 // Events Next Month
      	 $nextMonth1 = strtotime(date("31 M Y"), -5)+86401;
      	 $nextMonth2 = strtotime('next month');
      	 $nextMonthEvents = mysql_num_rows(mysql_query("SELECT * FROM events WHERE timefrom BETWEEN '".$nextMonth1."' AND '".$nextMonth2."'"));
      	 echo "<h4>Events Booked Next Month: " . $nextMonthEvents . "</h4>";
      	 ?>   
          <div class="content padding"> 
          </div>
         </div>
        </div>
  <?php 
	} else { 
	//If user does not have permission, show nothing
	}
  ?>
<!--Staff Noticeboard-->
  <div class="box one_half last">
   <div class="header">
    <h2>Staff Noticeboard</h2>
    <!--Toggle--> 
    <span class="toggle"></span> </div>
   <div class="content padding"> 
    <ul class="inbox">
     <?php 
     $staffQuery = mysql_query("SELECT * FROM noticeboard ORDER BY time DESC LIMIT 5");
     if(mysql_num_rows($staffQuery) == 0) { echo "No messages on the noticeboard."; }
     if(mysql_num_rows($staffQuery) != 0) {
      while($row = mysql_fetch_array($staffQuery)) {
       $staffName = mysql_result(mysql_query("SELECT name FROM users WHERE ID = '".$row['UID']."' "),0);
       $time = date("F j, Y g:i a", $row['time']);
       echo "
     	  <li> 
    	  <!--Avatar--> 
      	  <img alt=\"avatar\" class=\"avatar\" src=\"assets/user.png\" width=\"35\" height=\"35\"/> 
     	  <!--Author-->
          <div class=\"author\"> <a href=\"#\"></a>
          <h4>{$staffName}</h4>
          </div>
          <!--Meta-->
          <div class=\"meta\"> <a href=\"#\">{$time}</a></div>
          <!--Body-->
          <div class=\"body\">
           <p>{$row['notice']}</p>
          </div>
          </li>
       
	     <!--separator-->
    	 <li class=\"separator\"></li>

       ";
      }
     }
     ?>
     </ul>
    <div class="content padding"> 
    <!--Form Elements-->
    <form method="post" action="processAddNotice.php">
     <fieldset>
      <legend>New Notice</legend>
      <div class="field">
       <label>Notice</label>
       <textarea rows="7" cols="50" name="notice" ></textarea>
      </div>
      <button>Submit</button>
     </fieldset>
    </form>
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