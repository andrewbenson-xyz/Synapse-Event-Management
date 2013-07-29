<?php
// List upcoming events

listEvents
{
  echo "<!--Table-->
  <div class=\"box\"> 
   <!--Title-->
   <div class=\"header\">
    <h2><a href=\"#\">Upcoming Events</a></h2>
    <!--Toggle--> 
    <span class=\"toggle\"></span> </div>
   <!--Content-->
   <div class=\"content clearfix\"> 
    <!--Table-->
    <table class=\"datatable\">
     <thead>
      <tr>
       <th class=\"sorting_asc\"> Event Date </th>
       <th class=\"sorting\"> Name </th>
       <th class=\"sorting\"> Location </th>
       <th class=\"sorting\"> Price </th>
       <th class=\"sorting\"> DJ </th>
       <th class=\"sorting\"> Time </th>
       <th class=\"sorting\"> Phone </th>       
       <th class=\"sorting\"> Details </th>
      </tr>
     </thead>
     <tbody>";
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

}



?>