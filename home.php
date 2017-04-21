<?php
session_start();
include('include/db_connection.php');
$user_check=$_SESSION['login_user'];
// SQL Query To Fetch Complete Information Of User
$ses_sql=mysql_query("select * from admin_user_create where user_name='$user_check'");
$row = mysql_fetch_assoc($ses_sql);
$login_session_user_id 		=$row['id'];
$login_session_username 	=$row['user_name'];
$login_session_useremail 	=$row['user_email'];
$login_session_usertype 	=$row['user_type'];
if(!isset($login_session_user_id)){
mysql_close($connection); // Closing Connection
header('Location: index.php'); // Redirecting To Home Page
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  	<!-- 
  Theme Author: Mohammad Abdul Kaiyum
  Copyright: 	www.kaiyum.designercastle.com  
	-->
  <title>OH16 | Home</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <link rel="shortcut icon" type="image/png" href="images/k-logo-white.png"/>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/login_form.css">
    <link rel="stylesheet" href="css/oh16_custome.css">
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
  <script type="text/javascript" src="js/jquery.js"></script>
<!--  <script type="js/jquery.min.js"></script>-->
  <script type="js/bootstrap.min.js"></script>
  <script type="text/javascript">
      // show data list view function
      function show_datas(){
        // $(document).ready(function() {
        //$("#display").click(function() {                
        //alert('sdf');
        $.ajax({    //create an ajax request to load_page.php
        type: "GET",
        url: "home_controller.php",
        data: "action=list_view",
        dataType: "html",   //expect html to be returned   
        cache: false,       
        success: function(response){              
        $("#data_table_container").html(response);         
        //alert(response);
      }
      });
    //});
  // });
}
  </script>
<style>
.activee{
  background-color:#000;
}

</style>
</head>

<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60" onLoad="show_datas()";>
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#myPage"> <span style="font-size:40px; color:#fff;background-color:#EE5269; padding:7px;">a</span>bdul<span style="font-family:verdana;"></span><span style="font-size:40px; color:#fff; background-color:#3B5998; padding:7px;">k</span><span style="font-family:verdana;">aiyum</span> </a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
          <div class="dropdown">
             <a href="home.php"><button class="dropbtn activee">dashboard</button></a>
            <!--<div class="dropdown-content">
              <a href="#">Link 1</a>
              <a href="#">Link 2</a>
              <a href="#">Link 3</a>
            </div>-->
          </div>
	       <div class="dropdown">
            <a href="library/library_home.php"><button class="dropbtn">library</button></a>
            <!--<div class="dropdown-content">
              <a href="#">Link 1</a>
              <a href="#">Link 2</a>
              <a href="#">Link 3</a>
            </div>-->
          </div>
         <div class="dropdown">
             <a href="commercial/commercial_home.php"><button class="dropbtn">commercial</button></a>
            <!--<div class="dropdown-content">
              <a href="#">Link 1</a>
              <a href="#">Link 2</a>
              <a href="#">Link 3</a>
            </div>-->
          </div>
           <div class="dropdown">
            <a href="admin/admin_home.php"><button class="dropbtn">admin</button></a>
           <!-- <div class="dropdown-content">
              <a href="admin/user_create.php">user create</a>
              <a href="#">Link 2</a>
              <a href="#">Link 3</a>
            </div>-->
          </div>
       </ul>                     
    </div>
  </div>

</nav>

<div style="margin-top:50px; width:100%;" class="container-fluid">
<span>  
    <div class="page_path" style="float:right; margin-top:-20px;">
          <p id="welcome">
          User: <?php echo $login_session_username; ?> |
          <b id="logout"><a href="logout.php">Log Out</a></b>
          </p>
    </div>
  </span>

</div>
<h1 style="text-align:center;"> Dashboard</h1>

<!--dashboard -->

        <div class="col-md-12">
         <h2>order list</h2>
          <p><span class="glyphicon glyphicon-search search-boxs"></span><input type="text" id="search_user_create" placeholder="search" onKeyUp="fnc_search();"></p>
          <div id="data_table_container"></div>
        </div>


</body>
</html>
