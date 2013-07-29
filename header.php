<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>DJ Andrew Benson - Synapse</title>
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

<!--jQuery Uniform-->
<script src="plugins/jquery-uniform/jquery.uniform.min.js" type="text/javascript"></script>
<link href="plugins/jquery-uniform/css/uniform.default.css" rel="stylesheet" type="text/css">
<!--jQuery Excanvas-->
<!--[if IE]><script src="plugins/jquery-excanvas/excanvas.js" type="text/javascript"></script><![endif]-->
<!--jQuery Visualize-->
<script src="plugins/jquery-visualize/visualize.jQuery.js" type="text/javascript"></script>
<link href="plugins/jquery-visualize/visualize.css" rel="stylesheet" type="text/css">
<!--jQuery Tipsy-->
<script src="plugins/jquery-tipsy/jquery.tipsy.js" type="text/javascript"></script>
<link href="plugins/jquery-tipsy/tipsy.css" rel="stylesheet" type="text/css" />
<!--jQuery Datatables-->
<script src="plugins/jquery-datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<!--jQuery Facebox-->
<script src="plugins/jquery-facebox/facebox.js" type="text/javascript"></script>
<link rel="stylesheet" href="plugins/jquery-facebox/facebox.css" type="text/css" />
<!--Script Loader-->
<script src="plugins/loader.js" type="text/javascript"></script>

<!--Theme Variations-->
<script src="plugins/jquery.cookie.js" type="text/javascript"></script>
<script src="plugins/styleswitch.js" type="text/javascript"></script>

<link rel="stylesheet" href="css/color3/color.css" type="text/css" title="color3" />


</head>

<body class="altlayout">
<!--Header-->
<div id="header"> 
 <!--Container-->
 <div class="container clearfix"> 
  <!--Logo--> 
  <a href="index.php"><img id="logo" src="assets/logo.png" alt="synapse logo" /> </a>
  <!--Menu-->
  <!--Navigation-->
  <ul class="clearfix" id="navigation">
   <?php 
   
   if($pageTitle == "Dashboard") 
   { 
   	echo "<li class=\"current\"><a class=\"current\" href=\"index.php\">Dashboard</a></li>"; 
   } else { 
    echo "<li><a href=\"index.php\">Dashboard</a></li>"; 
   } 
   
   if($pageTitle == "Events") 
   { 
   	echo "<li class=\"current\"><a class=\"current\" href=\"events.php\" >Event Management</a></li>"; 
   } else { 
    echo "<li><a href=\"events.php\" >Event Management</a></li>"; 
   } 
   
   if($pageTitle == "Directory") 
   {
    echo "<li class=\"current\"><a class=\"current\" href=\"directory.php\">Employee Directory</a></li>"; 
   } else { 
    echo "<li><a href=\"directory.php\">Employee Directory</a></li>"; 
   } 

   $userPermissions = mysql_result(mysql_query("SELECT permissions FROM users WHERE username = '$_COOKIE[ID_my_site]' LIMIT 1"),0);
   if($userPermissions > 2) {
   	if($pageTitle == "Users") 
   	{
    	echo "<li class=\"current\"><a class=\"current\" href=\"userManagement.php\">User Management</a></li>"; 
   	} else { 
    	echo "<li><a href=\"userManagement.php\">User Management</a></li>"; 
   	}  
   } else { }
  
   if($pageTitle == "Account") 
   {
    echo "<li class=\"current\"><a class=\"current\" href=\"account.php\">Account Settings</a></li>"; 
   } else { 
    echo "<li><a href=\"account.php\">Account Settings</a></li>"; 
   }    
   
   if($pageTitle == "Logout") 
   {
    echo "<li class=\"current\"><a class=\"current\" href=\"logout.php\">Logout</a></li>"; 
   } else { 
    echo "<li><a href=\"logout.php\">Logout</a></li>";
   } 
   ?>
   <li class="separator"></li>
  </ul>
  <!--end container--> 
 </div>
 <!--end #header--> 
</div>
<!--Content-->
<div id="content">
 <div class="container clearfix">