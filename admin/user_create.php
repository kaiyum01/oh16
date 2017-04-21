<?php
// session page included here
session_start();
include('../include/db_connection.php');
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
header('Location: ../index.php'); // Redirecting To Home Page
}
//array_function.php
include('../include/array_function.php');
include('../include/message_function.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  	<!-- 
  Theme Author: Mohammad Abdul Kaiyum
  Copyright: 	www.kaiyum.designercastle.com  
	-->
  <title>OH16 | User Create</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <link rel="shortcut icon" type="image/png" href="images/k-logo-white.png"/>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/login_form.css">
  <link rel="stylesheet" href="../css/oh16_custome.css">
  <link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">
  <script type="text/javascript" src="../js/jquery.js"></script>
 <!-- <script type="../js/jquery.min.js"></script>-->
  <script type="../js/bootstrap.min.js"></script>

<script type="text/javascript">
// save data by submit button function
function data_send(){
  //$(document).ready(function(){  
  // $("#submit").click(function(){
  var username      = $("#txt_username").val();
  var useremail     = $("#txt_useremail").val();
  var userpassword  = $("#txt_userpassword").val();
  var againpass     = $("#txt_againuserpasswor").val();
  var usertype     	= $("#cbo_user_type").val();
  var status     	= $("#cbo_user_status").val();
  //var userstatus    = $("#contact").val();

  // Returns successful data submission message when the entered information is stored in database.
  var dataString = '&name1='+ username + '&email1='+ useremail + '&password1='+ userpassword + '&usertype1='+ usertype + '&status1='+ status;
  //alert(dataString);
  if( $("#txt_userpassword").val()!= $("#txt_againuserpasswor").val() )
  {
     $("#msg_failed").css({"display":"block","background-color":"#EE5269"}).fadeOut(8000).text('Password not matched');
    return;
  }
  if(username==''){ $("#username_red").css("color","#EE5269" );}else{ $("#username_red").css("color","green" );}
  if(userpassword==''){$("#userpass_red").css("color","#EE5269" );}else{$("#userpass_red").css("color","green" );}
  if(againpass==''){$("#againpass_red").css("color","#EE5269" ); }else{$("#againpass_red").css("color","green" ); }
  if(useremail==''){$("#usermail_red").css("color","#EE5269" );}else{$("#usermail_red").css("color","green" );}
  if(username==''||userpassword==''||againpass==''||useremail=='' ||usertype=='' || status==''){
     $("#msg_failed").css({"display":"block","background-color":"#EE5269"}).fadeOut(8000).html(" You have must fill out <b>red * mark</b>!"); 
  }
  else
  {
    //AJAX code to submit form.
    $.ajax({
      type: "POST",
      url: "controller/user_create_controller.php",
      data: dataString+'&action=save_data',
      cache: false,
      success: function(result)
      { 
        //alert(result);
        $("#msg_success").css({"display":"block","background-color":"#1E8A2B"}).fadeOut(8000).html(result); // message of html response after submiting data     
        $("#txt_username").val('');
        $("#txt_userpassword").val('');
        $("#txt_againuserpasswor").val('');
        $("#txt_useremail").val('');
		$('#cbo_user_type').val(1);
		$('#cbo_user_status').val(1);
        //default color of start mark
        $("#username_red").css("color","#555555" );
        $("#usermail_red").css("color","#555555" );
        $("#againpass_red").css("color","#555555" );
        $("#userpass_red").css("color","#555555" );
        //$("#update_id").val('');
        show_datas(); // call list view function_
      }
    });
  }
  return false;
// });
//});
}

    
// show data list view function
function show_datas(){
  // $(document).ready(function() {
    //$("#display").click(function() {                
    //alert('sdf');
      $.ajax({    //create an ajax request to load_page.php
      type: "GET",
      url: "controller/user_create_controller.php",
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
// onlick function for update get data
function get_data_from_list(id){
	//alert(id);
	query_data(id); // ajax function call
	//data_update()
	//$('#id').val(id);
}
//get data for update
function query_data(id){
// $(document).ready(function() {
//$("#display").click(function() {                
//alert('sdf');
	  $.ajax({    //create an ajax request to load_page.php
			type: "GET",
			url: "controller/user_create_controller.php",
			data:  'idd=' + id +'&action=getdata',			
			dataType: "json",   //expect html to be returned   
			cache: false,				
			success: function(results){											
				 //alert (results['id']);
				 $('#txt_username').val(results['user_name']);
				 $('#txt_useremail').val(results['user_email']);
				 $('#txt_userpassword').val(results['pass_word']);
				 $('#txt_againuserpasswor').val(results['pass_word']);
				 $('#cbo_user_type').val(results['user_type']);
				 $('#cbo_user_status').val(results['status_active']);
				 $('#update_id').val(results['id']);
				 $('#save').addClass('disabled', true);			 
				 $('#update').removeClass('disabled',false);
			}
	});
		//});
 //});
}
// Update data by submit button function
function data_update(){
	//$(document).ready(function(){  
	// $("#submit").click(function(){
	var username      	= $("#txt_username").val();
	var useremail    	= $("#txt_useremail").val();
	var userpassword  	= $("#txt_userpassword").val();
	var againpass     	= $("#txt_againuserpasswor").val();
	var usertype     	= $("#cbo_user_type").val();
	var status     		= $("#cbo_user_status").val();
	var id 				= $("#update_id").val();

	// Returns successful data submission message when the entered information is stored in database.
	var dataString = '&name1='+ username + '&email1='+ useremail + '&password1='+ userpassword + '&usertype1='+ usertype + '&status1='+ status + '&update_id1='+ id;
	 if( $("#txt_userpassword").val()!= $("#txt_againuserpasswor").val() )
  {
     $("#msg_failed").css({"display":"block","background-color":"#EE5269"}).fadeOut(8000).text('Password not matched');
    return;
  }
  if(username==''){ $("#username_red").css("color","#EE5269" );}else{ $("#username_red").css("color","green" );}
  if(userpassword==''){$("#userpass_red").css("color","#EE5269" );}else{$("#userpass_red").css("color","green" );}
  if(againpass==''){$("#againpass_red").css("color","#EE5269" ); }else{$("#againpass_red").css("color","green" ); }
  if(useremail==''){$("#usermail_red").css("color","#EE5269" );}else{$("#usermail_red").css("color","green" );}
  if(username==''||userpassword==''||againpass==''||useremail=='' ||usertype=='' || status==''){
     $("#msg_failed").css({"display":"block","background-color":"#EE5269"}).fadeOut(8000).html("You have must fill out <b>red * mark</b>!"); 
  }
  else
  {
    //AJAX code to submit form.
		$.ajax({
			type: "POST",
			url: "controller/user_create_controller.php",
			data: dataString+'&action=update_data',
			cache: false,
			success: function(result)
			{	
				 //alert(result);
			$("#msg_success").css({"display":"block","background-color":"#1E8A2B"}).fadeOut(8000).html(result); // message of html response after submiting data     
			$("#txt_username").val('');
			$("#txt_userpassword").val('');
			$("#txt_againuserpasswor").val('');
			$("#txt_useremail").val('');
			$('#cbo_user_type').val(1);
			$('#cbo_user_status').val(1);
			$('#update_id').val('');
			//default color of start mark
			$("#username_red").css("color","#555555" );
			$("#usermail_red").css("color","#555555" );
			$("#againpass_red").css("color","#555555" );
			$("#userpass_red").css("color","#555555" );
			show_datas(); // call list view function_
			$('#save').removeClass('disabled',false);			 
			$('#update').addClass('disabled', true);
												
			}
		});
	}
	return false;
//});
//});
}
//delte function
function fnc_delete(id){
	//alert(id);
	delete_data(id); // ajax function call
	//$('#id').val(id);
}
//  Delete Data function
function delete_data(id){
//$(document).ready(function() {
//$("#display").click(function() {                
//alert('sdf');
		var con_msg=confirm('Are you sure to delete data !');
		if(con_msg)
		{
			$.ajax({    //create an ajax request to load_page.php
				type: "POST",
				url: "controller/user_create_controller.php",
				data:  'delete_id=' + id +'&action=delete_data_action',	
				dataType: "text",   //expect html to be returned   
				cache: false,				
				success: function(responsee){						
					//$("#responsecontainer").html(response);					
					//alert(responsee);
					$("#msg_success").css({"display":"block","background-color":"#1E8A2B"}).fadeOut(8000).html(responsee); // message of html response after delete data
					show_datas();					
				}

			});
		}
		else
		{
			$("#msg_failed").css({"display":"block","background-color":"#EE5269"}).fadeOut(8000).html("Data not <b> deleted</b>!");
			show_datas();
		}
			  
		//});
 //});

}
//Search Function
function fnc_search(){
 var search_value= $("#search_user_create").val();
 //alert(search_value);
	 if(search_value==''){
		show_datas(); 
	 }
	 else{
	 search_data_table(search_value);
	 }
}
//Search data table ajax function
function search_data_table(search_value){
	// $(document).ready(function() {
		//$("#display").click(function() {                
		//alert('sdf');
		//alert(search_value); return;
			$.ajax({    //create an ajax request to load_page.php
			type: "GET",
			url: "controller/user_create_controller.php",
			data: 'search_value1='+search_value + '&action=search_list_view',
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

// active save btn when click reset btn
function active_save_btn(){
 $('#save').removeClass('disabled', false);
 $('#update').addClass('disabled',true);
}

</script>

<script>
function openNav() {
    document.getElementById("mySidenav").style.width = "200px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}
</script>
<!-- Horizontal menu js -->
</script>
<!-- Horizontal menu js -->
<script>
  $(document).ready(function(){
  $('ul li a').click(function(){
    $('li a').removeClass("active");
    $(this).addClass("active");
});
});

</script>
<style type="text/css">
.sidenav {
    height: 100%;
    width: 0;
    position: fixed;
    z-index: 1111;
    top: 0;
    left: 0;
     background: rgba(000, 00, 00, 0.8);
    overflow-x: hidden;
    transition: 0.5s;
    padding-top: 60px;
    margin-top: 150px;
	
}

.sidenav a {
    padding: 8px 8px 8px 32px;
    text-decoration: none;
    font-size: 16px;
    color: #f2f2f2;
    display: block;
    transition: 0.3s;
	font-weight:bolder;
}

.sidenav a:hover, .offcanvas a:focus{
    color: #000;
	background-color:#fff;
}

.sidenav .closebtn {
    position: absolute;
    top: 0;
    right: 25px;
    font-size: 36px;
    margin-left: 50px;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
/* class control-label" font size minimizaton */
.control-label
{
  font-size: 12px;
  padding: 0px;
}
.form-group
{
  padding: 0px;
  margin: 2px;
}
/* horizontal menu style */
nav ul li{
  list-style:none;
  float:left;
  padding-right:2px;
}
nav ul li a{
  text-decoration:none;
  color:#222;
  background-color:#ccc;
  padding:8px 8px;
  text-decoration: none !important;
}
nav ul li a:hover{
  background-color: black;
  color:white;
  }
.active{
  background-color:#d90000;
  color:#fff;

}
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
      <a class="navbar-brand" href="#myPage"> <span style="font-size:40px; color:#fff;background-color:#EE5269; padding:7px;">A</span>bdul <span style="font-family:verdana;"></span><span style="font-size:40px; color:#fff; background-color:#3B5998; padding:7px;">K</span><span style="font-family:verdana;">aiyum</span> </a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
      <div class="dropdown">
             <a href="../home.php"><button class="dropbtn">dashboard</button></a>
            <!--<div class="dropdown-content">
              <a href="#">Link 1</a>
              <a href="#">Link 2</a>
              <a href="#">Link 3</a>
            </div>-->
          </div>
	     <div class="dropdown">
         <a href="../library/library_home.php"><button class="dropbtn">library</button></a>
            <!--<div class="dropdown-content">
              <a href="#">Link 1</a>
              <a href="#">Link 2</a>
              <a href="#">Link 3</a>
            </div>-->
          </div>
         <div class="dropdown">
            <a href="../commercial/commercial_home.php"><button class="dropbtn">commercial</button></a>
            <!--<div class="dropdown-content">
              <a href="#">Link 1</a>
              <a href="#">Link 2</a>
              <a href="#">Link 3</a>
            </div>-->
          </div>
           <div class="dropdown">
            <a href="admin_home.php"><button class="dropbtn activee">admin</button></a>
            <!--<div class="dropdown-content">
              <a href="#">create user</a>
              <a href="#">Link 2</a>
              <a href="#">Link 3</a>
            </div>-->
          </div>
       </ul>                     
    </div>
  </div>
</nav>

<div class="container-fluid" style="margin-top:60px; padding:0;">

<div class="container-fluid page_path_div" style=" background-color:#fff; height:auto; width:98%;color:#666666;">
  <div class="page_path" style="float:left;">Admin / User Create</div>
  <div class="pagename" style="float:right;">Page: User create</div><hr/>

    <div id="mySidenav" class="sidenav">
      <a href="javascript:void(0)" class="closebtn" onClick="closeNav()">&times;</a>
      
      <li><a href="user_create.php">User Create</a></li>
      
     
  </div>
  <span style="font-size:20px;cursor:pointer; float:left;" onClick="openNav()">&#9776; open</span>
  

<div class="horizontal_menu" style="float:left; text-align:center; margin-left: 38%;">
    <nav class="navecation"> 
      <ul id="navv">    
        <li><a class="menu active" href="user_create.php">User Create</a></li>
      </ul>
    </nav>
</div>

  <span>  
    <div class="page_path" style="float:right; margin-top:-20px;">
          <p id="welcome">
          User: <?php echo $login_session_username; ?> |
          <b id="logout"><a href="../logout.php">Log Out</a></b>
          </p>
    </div>
  </span>

</div>






			
  <div class="col-md-6">
      <h2>user create / update form</h2>
      <p>you can create / update user by using this form</p>
  <form class="form-horizontal">
    <div class="form-group">
      <label class="control-label col-sm-4" for="username">User Name:</label>
      <div class="col-sm-8">
       <div class="input-group">
        <input type="text" class="form-control" id="txt_username" name="txt_username" placeholder="Enter user name">
        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk" id="username_red"></span></span>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-4" for="pwd">Password:</label>
      <div class="col-sm-8">
       <div class="input-group">
        <input type="password" class="form-control" id="txt_userpassword" name="txt_userpassword" placeholder="Enter password">
        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk" id="userpass_red"></span></span>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-4" for="apwd">Again Password:</label>
      <div class="col-sm-8">
       <div class="input-group">
        <input type="password" class="form-control" id="txt_againuserpasswor" name="txt_againuserpasswor" placeholder="Enter again password">
        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk" id="againpass_red"></span></span>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-4" for="email">Email:</label>
      <div class="col-sm-8">
      <div class="input-group">
        <input type="email" class="form-control" id="txt_useremail" name="txt_useremail" placeholder="Enter email">
        <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk" id="usermail_red"></span></span>
        </div>
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-4" for="sel1">User Type:</label>
      <div class="col-sm-8">
      <div class="input-group">
        <select style="margin-left:8px;" class="form-control" id="cbo_user_type" name="cbo_user_type">
          	<?php
			foreach ($user_type as $user_type_key => $user_type_name) {
			?><option value="<?php echo $user_type_key; ?>" <?php /*?><?php if( $imvalue==$updata['Timportancy'])  echo "selected"; ?> <?php */?>><?php echo $user_type_name ?>
			</option>	
			<?php
			}
			?>
        </select> 
        <span class="input-group-addon"></span>
        </div>
      </div>
    </div>
	 <div class="form-group">
      <label class="control-label col-sm-4" for="sel1">Status:</label>
      <div class="col-sm-8">
      <div class="input-group">  
        <select style="margin-left:8px;" class="form-control" id="cbo_user_status" name="cbo_user_status">
			<?php
			foreach ($status as $status_key => $status_name) {
			?><option value="<?php echo $status_key; ?>" <?php /*?><?php if( $imvalue==$updata['Timportancy'])  echo "selected"; ?> <?php */?>><?php echo $status_name ?>
			</option>	
			<?php
			}
			?>
        </select> 
        <span class="input-group-addon"></span>
        </div>
      </div>
    </div>
	<input type="hidden" id="update_id" name="update_id">
    <div class="form-group">
      <label class="control-label col-sm-4" for="sel1"></label>
      <div class="col-sm-2">
      </div>
      <div class="col-sm-6">
         <div class="input-group">
            <button type="button" class="btn btn-default" id="save" onClick="data_send();">Create</button>
			<button type="button" class="btn btn-default disabled" id="update" onClick="data_update();">Update</button>          
            <button type="reset" class="btn btn-default" onClick="active_save_btn();">Reset</button>
        </div>
      </div>
    </div>
  </form>
    <div class="col-md-4">
    </div>
    <div class="col-md-8">
    <p style="background-color:#f9f9f9;color:#fff; display:none;" id="msg_success"></p>
    <p style="background-color:#f3f3f3;;color:#fff; display:none;" id="msg_failed"></p>
    </div> 
  </div>
  <div class="col-md-6">
     <h2>user list</h2>
  	<p><span class="glyphicon glyphicon-search search-boxs"></span><input type="text" id="search_user_create" placeholder="search" onKeyUp="fnc_search();"></p>
  <div id="data_table_container"></div>
  </div>
  
</div>
			
</body>
</html>
