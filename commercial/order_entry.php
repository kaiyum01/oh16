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
include('../include/common_function.php');
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
  <title>OH16 | Order Entry</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <link rel="shortcut icon" type="image/png" href="images/k-logo-white.png"/>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/login_form.css">
  <link rel="stylesheet" href="../css/oh16_custome.css">
  <link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">

  <script type="text/javascript" src="../js/jquery.js"></script>
 <!-- <script type="../js/jquery.min.js"></script>-->
  <script type="text/javascript" src="../js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../css/jquery_ui.css">
  <script type="text/javascript" src="../js/jquery_ui.js"></script>
  

<script type="text/javascript">
// show data list QUOTATION view function
function show_datas_quotation(){
  // $(document).ready(function() {
    //$("#display").click(function() {                
    //alert('sdf');
      $.ajax({    //create an ajax request to load_page.php
      type: "GET",
      url: "controller/order_entry_controller.php",
      data: "action=list_view_quotation",
      dataType: "html",   //expect html to be returned   
      cache: false,       
      success: function(response){              
      $("#data_table_container_quotation").html(response);         
        //alert(response);
      }
      });
    //});
  // });
}

// save data by submit button function
function data_send(){
  //$(document).ready(function(){  
  // $("#submit").click(function(){
  //var order_no        = $("#txt_order_no").val();
  var order_date      = $("#txt_order_date").val();
  var client_name     = $("#cbo_client_name").val();
  var short_name     = $("#txt_short_name").val();
  var task_type       = $("#cbo_task_type").val();
  var quotation_no    = $("#cbo_quotation_no").val();
  var quotation_date  = $("#txt_quotation_date").val();
  //var job_no          = $("#txt_job_no").val();
  var production_status = $("#cbo_production_status").val();
  var delivery_date   = $("#txt_delivery_date").val();
  //var challan_no      = $("#txt_challan_no").val();
  //var bill_no         = $("#txt_bill_no").val();
  var bill_status     = $("#cbo_bill_status").val();

  //var userstatus    = $("#contact").val();

  // Returns successful data submission message when the entered information is stored in database.
  var dataString = '&order_date1='+ order_date + '&client_name1='+ client_name + '&short_name1='+ short_name +
   '&task_type1='+ task_type  + '&quotation_no1='+ quotation_no + '&quotation_date1='+ quotation_date + 
   '&production_status1='+ production_status + '&delivery_date1='+ delivery_date + '&bill_status1='+ bill_status;
  alert(dataString);
  if(order_date==''){$("#order_date_red").css("color","#EE5269" );}else{$("#order_date_red").css("color","green" );}
  if(client_name==''){$("#client_name_red").css("color","#EE5269" ); }else{$("#client_name_red").css("color","green" ); }
  if(task_type==''){$("#task_red").css("color","#EE5269" );}else{$("#task_red").css("color","green" );}
  if(quotation_no==''){$("#quot_no_red").css("color","#EE5269" );}else{$("#quot_no_red").css("color","green" );}
  if(quotation_date==''){ $("#quotation_date_red").css("color","#EE5269" );}else{ $("#quotation_date_red").css("color","green" );}
  if(production_status==''){$("#production_status_red").css("color","#EE5269" ); }else{$("#production_status_red").css("color","green" ); }
  if(delivery_date==''){$("#delivery_date_red").css("color","#EE5269" );}else{$("#delivery_date_red").css("color","green" );}
  if(bill_status==''){$("#bill_status_red").css("color","#EE5269" ); }else{$("#bill_status_red").css("color","green" ); }
  if(order_date==''||client_name==''||task_type=='' ||quotation_date=='' || production_status==''||delivery_date=='' || bill_status==''){
     $("#msg_failed").css({"display":"block","background-color":"#EE5269"}).fadeOut(8000).html(" You have must fill out <b>red * mark</b>!"); 
  }
  else
  {
    //AJAX code to submit form.
    $.ajax({
      type: "POST",
      url: "controller/order_entry_controller.php",
      data: dataString+'&action=save_data',
      cache: false,
      success: function(result)
      { 
        //alert(result);
        $("#msg_success").css({"display":"block","background-color":"#1E8A2B"}).fadeOut(8000).html(result); // message of html response after submiting data     
        //$("#txt_order_no").val('');
        $("#txt_order_date").val('');
        $("#cbo_client_name").val(''); 
		$("#txt_short_name").val('');
        $("#cbo_task_type").val('');
        $("#cbo_quotation_no").val('');
        $("#txt_quotation_date").val('');
        //$("#txt_job_no").val('');
        $("#cbo_production_status").val('0');
        $("#txt_delivery_date").val('');
        //$("#txt_challan_no").val('');
        //$("#txt_bill_no").val('');
        $("#cbo_bill_status").val('0');    
        //default color of start mark
        //$("#order_no_red").css("color","#555555" );
        $("#order_date_red").css("color","#555555" );
        $("#client_name_red").css("color","#555555" );
        $("#task_red").css("color","#555555" );
        $("#quot_no_red").css("color","#555555" );
        $("#quotation_date_red").css("color","#555555" );
        //$("#job_id_red").css("color","#555555" );
        $("#production_status_red").css("color","#555555" );
        $("#delivery_date_red").css("color","#555555" );
        //$("#challan_no_red").css("color","#555555" );
        //$("#bill_no_red").css("color","#555555" );
        $("#bill_status_red").css("color","#555555" );
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
      url: "controller/order_entry_controller.php",
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
// onlick function for pickup quotation data
function get_data_from_list_quotation(id){
  //alert(id);
  query_data_quotation(id); // ajax function call
  //data_update()
  //$('#id').val(id);
}
// onlick function for update get data
function get_data_from_list(id){
	//alert(id);
	query_data(id); // ajax function call
	//data_update()
	//$('#id').val(id);
}
//get data for update
function query_data_quotation(id){
// $(document).ready(function() {
//$("#display").click(function() {                
//alert('sdf');
    $.ajax({    //create an ajax request to load_page.php
      type: "GET",
      url: "controller/order_entry_controller.php",
      data:  'idd=' + id +'&action=getdata_quotation',      
      dataType: "json",   //expect html to be returned   
      cache: false,       
      success: function(results){                   
         //alert (results['quotation_number_generate']);
         //alert (results['orderId']);
         // get order id,quotation id//6-10-2016
         //show_detail_form(results['quotationId']);
/*var len = results.length;
for (var i = 0; i < len; i++) {
    console.log(results[i].phone);
}*/
         $("#txt_quotation_date").val(results['quotation_date']);
         $("#cbo_quotation_no").val(results['id']);
         $("#cbo_client_name").val(results['to_company']);
		 $("#txt_short_name").val(results['short_name']);
		 
		 
        /* $("#cbo_to_com_name").val(results['to_company']);
         $("#txt_to_address").val(results['to_address']);
         $("#txt_to_subject").val(results['to_quotation_subject']);
         $('#update_id').val('');

         $("#hidden_quotation_id").val(results['quotationId']);
         $("#hidden_order_id").val(results['orderId']);*/

         $('#save').removeClass('disabled', true);      
         $('#update').addClass('disabled',false);
         //$('#print').removeClass('disabled',false);
         $('#txt_quotation_date').addClass('disabled',false);
         $('#cbo_quotation_no').addClass('disabled',false);
          $('#cbo_client_name').addClass('disabled',false);
        
         

         //$('#update').addClass('disabled',false);

          //for print data
         /* var to_name= results['quotation_date'];
          var to_designation=results['quotation_number_generate'];
          var to_company=results['to_company'];
          var to_address=results['to_address'];
          var to_quotation_subject=results['to_quotation_subject']; */
          
          //var word=total_amount_with_vat;
      }
  });
    //});
 //});
}
//get data for update
function query_data(id){
// $(document).ready(function() {
//$("#display").click(function() {                
//alert('sdf');
	  $.ajax({    //create an ajax request to load_page.php
			type: "GET",
			url: "controller/order_entry_controller.php",
			data:  'idd=' + id +'&action=getdata',			
			dataType: "json",   //expect html to be returned   
			cache: false,				
			success: function(results){											
			   //alert (results['id']);
        $('#txt_order_no').val(results['order_number_generate']);
        $('#txt_order_date').val(results['order_date']);
        $('#cbo_client_name').val(results['client_name']);
        $('#cbo_task_type').val(results['task_name']);
        $('#cbo_quotation_no').val(results['quotation_no']);
        $('#txt_quotation_date').val(results['quotation_date']);
        $('#txt_job_no').val(results['job_number_generate']);
        $('#cbo_production_status').val(results['production_status']);
        $('#txt_delivery_date').val(results['delivery_date']);
        //$('#txt_challan_no').val(results['challan_no']);
        //$('#txt_bill_no').val(results['bill_no']);
        $('#cbo_bill_status').val(results['bill_status']);

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
 
  var order_date      = $("#txt_order_date").val();
  var client_name     = $("#cbo_client_name").val();
  var task_type       = $("#cbo_task_type").val();
  var quotation_no    = $("#cbo_quotation_no").val();
  var quotation_date  = $("#txt_quotation_date").val();
 
  var production_status = $("#cbo_production_status").val();
  var delivery_date   = $("#txt_delivery_date").val();
  //var challan_no      = $("#txt_challan_no").val();
  //var bill_no         = $("#txt_bill_no").val();
  var bill_status     = $("#cbo_bill_status").val();
	var id 				      = $("#update_id").val();

	// Returns successful data submission message when the entered information is stored in database.
	var dataString = '&order_date1='+ order_date + '&client_name1='+ client_name +
   '&task_type1='+ task_type  + '&quotation_no1='+ quotation_no + '&quotation_date1='+ quotation_date + 
   '&production_status1='+ production_status + '&delivery_date1='+ delivery_date + '&bill_status1='+ bill_status + '&update_id1='+ id;
  //alert(dataString);
 
  if(order_date==''){$("#order_date_red").css("color","#EE5269" );}else{$("#order_date_red").css("color","green" );}
  if(client_name==''){$("#client_name_red").css("color","#EE5269" ); }else{$("#client_name_red").css("color","green" ); }
  if(task_type==''){$("#task_red").css("color","#EE5269" );}else{$("#task_red").css("color","green" );}
  if(quotation_no==''){$("#quot_no_red").css("color","#EE5269" );}else{$("#quot_no_red").css("color","green" );}
  if(quotation_date==''){ $("#quotation_date_red").css("color","#EE5269" );}else{ $("#quotation_date_red").css("color","green" );}
  if(production_status==''){$("#production_status_red").css("color","#EE5269" ); }else{$("#production_status_red").css("color","green" ); }
  if(delivery_date==''){$("#delivery_date_red").css("color","#EE5269" );}else{$("#delivery_date_red").css("color","green" );}
  if(bill_status==''){$("#bill_status_red").css("color","#EE5269" ); }else{$("#bill_status_red").css("color","green" ); }
   if(order_date==''||client_name==''||task_type=='' ||quotation_date=='' || production_status==''||delivery_date=='' || bill_status==''){
     $("#msg_failed").css({"display":"block","background-color":"#EE5269"}).fadeOut(8000).html(" You have must fill out <b>red * mark</b>!"); 
  }
  else
  {
    //AJAX code to submit form.
		$.ajax({
			type: "POST",
			url: "controller/order_entry_controller.php",
			data: dataString+'&action=update_data',
			cache: false,
			success: function(result)
			{	
				 //alert(result);
			$("#msg_success").css({"display":"block","background-color":"#1E8A2B"}).fadeOut(8000).html(result); // message of html response after submiting data     
      $("#txt_order_no").val('');
      $("#txt_order_date").val('');
      $("#cbo_client_name").val(''); 
      $("#cbo_task_type").val('');
      $("#cbo_quotation_no").val('');
      $("#txt_quotation_date").val('');
      $("#txt_job_no").val('');
      $("#cbo_production_status").val('0');
      $("#txt_delivery_date").val('');
      //$("#txt_challan_no").val('');
      //$("#txt_bill_no").val('');
      $("#cbo_bill_status").val('0');  
      $('#update_id').val('');
			//default color of start mark
      $("#order_no_red").css("color","#555555" );
      $("#order_date_red").css("color","#555555" );
      $("#client_name_red").css("color","#555555" );
      $("#task_red").css("color","#555555" );
      $("#quot_no_red").css("color","#555555" );
      $("#quotation_date_red").css("color","#555555" );
      $("#job_id_red").css("color","#555555" );
      $("#production_status_red").css("color","#555555" );
      $("#delivery_date_red").css("color","#555555" );
      //$("#challan_no_red").css("color","#555555" );
      //$("#bill_no_red").css("color","#555555" );
      $("#bill_status_red").css("color","#555555" );
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
				url: "controller/order_entry_controller.php",
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
//Search Function quotation
function fnc_search_quotation(){
 var search_value= $("#search_user_create_quotation").val();
 //alert(search_value);
   if(search_value==''){
    show_datas_quotation(); 
   }
   else{
   search_data_table_quotation(search_value);
   }
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
//Search data table order ajax function
function search_data_table_quotation(search_value){
  // $(document).ready(function() {
    //$("#display").click(function() {                
    //alert('sdf');
    //alert(search_value); return;
      $.ajax({    //create an ajax request to load_page.php
      type: "GET",
      url: "controller/order_entry_controller.php",
      data: 'search_value1='+search_value + '&action=search_list_view_quotation',
      dataType: "html",   //expect html to be returned   
      cache: false,       
      success: function(response){              
      $("#data_table_container_quotation").html(response);          
        //alert(response);
      }
      });
    //});
  // });
}

//Search data table ajax function
function search_data_table(search_value){
	// $(document).ready(function() {
		//$("#display").click(function() {                
		//alert('sdf');
		//alert(search_value); return;
			$.ajax({    //create an ajax request to load_page.php
			type: "GET",
			url: "controller/order_entry_controller.php",
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

 $(function() {
            $( "#txt_order_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
            $( "#txt_delivery_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
         });
		 
		 
		 
		 
// scrolling table list view START
// Change the selector if needed
var $table = $('table.scroll'),
    $bodyCells = $table.find('tbody tr:first').children(),
    colWidth;

// Adjust the width of thead cells when window resizes
$(window).resize(function() {
    // Get the tbody columns width array
    colWidth = $bodyCells.map(function() {
        return $(this).width();
    }).get();
    
    // Set the width of thead columns
    $table.find('thead tr').children().each(function(i, v) {
        $(v).width(colWidth[i]);
    });    
}).resize(); // Trigger resize handler
//// scrolling table list view END
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

<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60" onLoad="show_datas_quotation();show_datas()";>
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
            <a href="commercial_home.php"><button class="dropbtn activee">commercial</button></a>
            <!--<div class="dropdown-content">
              <a href="#">Link 1</a>
              <a href="#">Link 2</a>
              <a href="#">Link 3</a>
            </div>-->
          </div>
           <div class="dropdown">
            <a href="../admin/admin_home.php"><button class="dropbtn">admin</button></a>
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
  <div class="page_path" style="float:left;">Commercial / Order Entry</div>
  <div class="pagename" style="float:right;">Page: Order Entry</div><hr/>

    <div id="mySidenav" class="sidenav">
      <a href="javascript:void(0)" class="closebtn" onClick="closeNav()">&times;</a>
      
        <li><a href="create_quotation.php">Create quotation</a></li>
         <li><a href="order_entry.php">Order Entry</a></li>
         <li><a href="create_bill.php">Create bill</a></li>
         <li><a href="create_challan.php">Create challan</a></li> 
      
     
  </div>
  <span style="font-size:20px;cursor:pointer; float:left;" onClick="openNav()">&#9776; open</span>
  
<div class="horizontal_menu" style="float:left; text-align:center; margin-left: 25%;">
    <nav class="navecation"> 
      <ul id="navv">
        <li><a class="menu "  href="create_quotation.php">Create quotation</a></li>
        <li><a class="menu active" href="order_entry.php">Order Entry</a></li>
        <li><a class="menu" href="create_bill.php">Create bill</a></li>
        <li><a class="menu" href="create_challan.php">Create challan</a></li>
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

</div>



<div class="container-fluid">
  <div class="col-md-12">
      <div class="col-md-12">
            <!-- modal start -->
        <!-- Trigger the modal with a button -->
        <button  type="button" class="btn btn-primary btn-sm center-block" data-toggle="modal" data-target="#myModal">Browse Quotation</button>
        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
          <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h2 style="margin-right:20px;" class="modal-title">Quotation list</h2>
               
              </div>
              <div class="modal-body">
                      <p style="margin-top:-10px;"><span class="glyphicon glyphicon-search search-boxs"></span><input type="text" id="search_user_create_quotation" placeholder="search" onKeyUp="fnc_search_quotation();"></p>
                      <div style="margin-top:-20px;" id="data_table_container_quotation"></div>
                                    
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
            
          </div>
        </div>           
              <!-- modal end -->  
     </div>

    <form class="form-horizontal"> 
      <div class="col-md-6">    
          <div class="form-group">
            <label class="control-label col-sm-4" for="ord-no">Order No:</label>
            <div class="col-sm-8">
             <div class="input-group">
              <input type="text" class="form-control" id="txt_order_no" name="txt_order_no" placeholder="Order Number" readonly>
              <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk" id="order_no_red"></span></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-4" for="sel1">Client Name:</label>
            <div class="col-sm-8">
            <div class="input-group">
              <select style="margin-left:9px;" class="form-control" id="cbo_client_name" name="cbo_client_name" disabled>
              <option value="0">--- Select Client ---</option>
                  <?php
            $sql="select id,company_name from lib_client_entry where status_active=1 and is_deleted=0";
            $sql_qry=mysql_query($sql);
            $j=1;
            while($row=mysql_fetch_array($sql_qry)){
            ?>
            <option value="<?php echo $row['id']; ?>"><?php echo $row['company_name']; ?></option>
            <?php
            $j++;
            }
            ?>
              </select> 
			  <input type="hidden" id="txt_short_name" name="txt_short_name" value="<?php echo $row['short_name']; ?>">
              <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk" id="client_name_red"></span></span>
              </div>
            </div>
          </div>
           <div class="form-group">
            <label class="control-label col-sm-4" for="qno">Quotation No:</label>
            <div class="col-sm-8">
            <div class="input-group">
              <select style="margin-left:9px;" class="form-control" id="cbo_quotation_no" name="cbo_quotation_no" disabled>
              <option value="0">--- Select Quotation No ---</option>
                  <?php
            $sql="select id,quotation_number_generate from com_create_quotation_mst where status_active=1 and is_deleted=0 order by id DESC";
            $sql_qry=mysql_query($sql);
            $j=1;
            while($row=mysql_fetch_array($sql_qry)){
            ?>
            <option value="<?php echo $row['id']; ?>"><?php echo $row['quotation_number_generate']; ?></option>
            <?php
            $j++;
            }
            ?>
              </select> 
              <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk" id="quot_no_red"></span></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-4" for="q_date">Quotation Date:</label>
            <div class="col-sm-8">
             <div class="input-group">
              <input type="text" class="form-control" id="txt_quotation_date" name="txt_quotation_date" disabled>
              <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk" id="quotation_date_red"></span></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-4" for="job_no">Job Number:</label>
            <div class="col-sm-8">
            <div class="input-group">
              <input type="text" class="form-control" id="txt_job_no" name="txt_job_no" placeholder="Job Number" readonly>
              <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk" id="job_id_red"></span></span>
              </div>
            </div>
          </div>
      </div>
        <!-- from end part -->
      <div class="col-md-6">



          <div class="form-group">
            <label class="control-label col-sm-4" for="ordr_date">Order Date:</label>
            <div class="col-sm-8">
             <div class="input-group">
              <input type="text" class="form-control" id="txt_order_date" name="txt_order_date" placeholder="Year-Month-Day">
              <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk" id="order_date_red"></span></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-4" for="tsk">Task Type / Name:</label>
            <div class="col-sm-8">
            <div class="input-group">
              <select style="margin-left:9px;" class="form-control" id="cbo_task_type" name="cbo_task_type">
                  <?php
            $sql="select id,task_name from lib_task_entry where status_active=1 and is_deleted=0";
            $sql_qry=mysql_query($sql);
            $j=1;
            while($row=mysql_fetch_array($sql_qry)){
            ?>
            <option value="<?php echo $row['id']; ?>"><?php echo $row['task_name']; ?></option>
            <?php
            $j++;
            }
            ?>
              </select> 
              <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk" id="task_red"></span></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-4" for="p_sts">Production Status:</label>
            <div class="col-sm-8">
            <div class="input-group">
              <select style="margin-left:9px;" class="form-control" id="cbo_production_status" name="cbo_production_status">
                  <?php
            foreach ($production_status as $production_status_key => $production_status_name) {
            ?><option value="<?php echo $production_status_key; ?>" <?php /*?><?php if( $imvalue==$updata['Timportancy'])  echo "selected"; ?> <?php */?>><?php echo $production_status_name ?>
            </option> 
            <?php
            }
            ?>
              </select> 
              <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk" id="production_status_red"></span></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-4" for="d_date">Delivery Date:</label>
            <div class="col-sm-8">
             <div class="input-group">
              <input type="text" class="form-control" id="txt_delivery_date" name="txt_delivery_date" placeholder="Year-Month-Day">
              <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk" id="delivery_date_red"></span></span>
              </div>
            </div>
          </div>
         <div class="form-group">
            <label class="control-label col-sm-4" for="billsts">Bill Status:</label>
            <div class="col-sm-8">
            <div class="input-group">  
              <select style="margin-left:9px;" class="form-control" id="cbo_bill_status" name="cbo_bill_status">
            <?php
            foreach ($bill_status as $status_key => $status_name) {
            ?><option value="<?php echo $status_key; ?>" <?php /*?><?php if( $imvalue==$updata['Timportancy'])  echo "selected"; ?> <?php */?>><?php echo $status_name ?>
            </option> 
            <?php
            }
            ?>
              </select> 
             <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk" id="bill_status_red"></span></span>
              </div>
            </div>
          </div>
      </div>

               <input type="hidden" id="update_id" name="update_id">
      
                <div style="margin-top:20px;" class="col-md-7 col-md-offset-5">
                   <div  class="input-group">
                      <button type="button" class="btn btn-default" id="save" onClick="data_send();">Create</button>
                      <button type="button" class="btn btn-default disabled" id="update" onClick="data_update();">Update</button>          
                      <button type="reset" class="btn btn-default" onClick="active_save_btn();">Reset</button>
                  </div>
                </div>
             
            </form>
              
              <div class="col-md-12">
                <p style="background-color:#f9f9f9;color:#fff; display:none;" id="msg_success"></p>
                <p style="background-color:#f3f3f3;;color:#fff; display:none;" id="msg_failed"></p>
              </div> 

  </div>
  
         <div class="col-md-12">
         <h2>order list</h2>
          <p><span class="glyphicon glyphicon-search search-boxs"></span><input type="text" id="search_user_create" placeholder="search" onKeyUp="fnc_search();"></p>
          <div id="data_table_container"></div>
        </div>

</div>
	
</body>
</html>
