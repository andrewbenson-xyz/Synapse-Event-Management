<?php 
// Global Error Reporting
error_reporting(0);
// Estabish MySQL Connection
$con = mysql_connect("hostname","DB Username","DB Password");
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

  mysql_select_db("DB Name") or die(mysql_error());
 
?>