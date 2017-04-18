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
include('../include/kaiyum_function.php');
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
  <title>OH16 | Quotation Entry</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <link rel="shortcut icon" type="image/png" href="images/k-logo-white.png"/>
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/login_form.css">
  <link rel="stylesheet" href="../css/oh16_custome.css">
  <link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">
  <script type="text/javascript" src="../include/function_for_js.js"></script>
  <script type="text/javascript" src="../js/jquery.js"></script>
 <!-- <script type="../js/jquery.min.js"></script>-->
  <script type="../js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="../css/jquery_ui.css">
  <script type="text/javascript" src="../js/jquery_ui.js"></script>
<script type="text/javascript">
// save data by submit button function
function data_send(){
  //$(document).ready(function(){  
  // $("#submit").click(function(){
        var to_quotation_date  = $("#txt_quotation_date").val(); 
        var to_name         = $("#txt_to_name").val();
        var to_designation  = $("#txt_to_desig").val();
        var to_company      = $("#cbo_to_com_name").val();
		    var to_short_company = $("#txt_to_short_name").val();
        var to_address      = $("#txt_to_address").val();
        var to_subject      = $("#txt_to_subject").val();
        var total_amount    = $("#subtotal").val();
        var vat             = $("#vat").val();
		    var ait             = $("#ait").val();
        var total_with_vat  = $("#total_with_vat").val();
        var takainword      = $("#takainword").val();


        //notes
		var noteArray=[];
		$("input:checkbox[name=note]:checked").each(function(){
		    noteArray.push($(this).val());
		});
		var noteStr = noteArray.join(",");
		//alert(noteStr);return;

        var dataString = '&to_quotation_date='+ to_quotation_date +'&to_name='+ to_name + '&to_designation='+ to_designation + '&to_company='+ to_company + '&to_short_company='+ to_short_company + '&to_address='+ to_address + '&to_subject='+ to_subject + '&total_amount='+ total_amount + '&vat='+ vat + '&ait='+ ait + '&total_with_vat='+ total_with_vat + '&takainword='+ takainword + '&noteStr='+ noteStr;
    	//alert(dataString);

        var row_count=$('#tbl_quotation_id tbody tr').length;
        //alert(row_count);return;
        var data_dtls="";
        for( var i = 1; i <= row_count; i++ )
        {
        
            data_dtls+="&txtItem_" + i + "=" + $('#txtItem_'+i).val()+""+"&txtHeightFeet_" + i + "=" 
            + $('#txtHeightFeet_'+i).val()+""+"&txtHeightInch_" + i + "=" + $('#txtHeightInch_'+i).val()+""+"&txtWidthFeet_" 
            + i + "=" + $('#txtWidthFeet_'+i).val()+""+"&txtWidthInch_" + i + "=" + $('#txtWidthInch_'+i).val()+""+"&txtSqrft_" 
            + i + "=" + $('#txtSqrft_'+i).val()+""+"&txtPrice_" + i + "=" + $('#txtPrice_'+i).val()+""+"&txtQty_" 
			+ i + "=" + $('#txtQty_'+i).val()+""+"&txtUnitTotalPrice_" + i + "=" + $('#txtUnitTotalPrice_'+i).val()+"";
  
        }
          
/*   if(to_name==''||to_designation==''){
          $("#msg_failed").css({"display":"block","background-color":"#EE5269"}).fadeOut(8000).html(" You have must fill out <b>red * mark</b>!"); 
  }*/
  if(to_name==''){ $("#to_name_red").css("color","#EE5269" );}else{ $("#to_name_red").css("color","green" );}
  //if(to_designation==''){ $("#to_desi_red").css("color","#EE5269" );}else{ $("#to_desi_red").css("color","green" );}
  if(to_quotation_date==''){$("#quotation_date_red").css("color","#EE5269" );}else{$("#quotation_date_red").css("color","green" );}
  if(to_address==''){ $("#to_address_red").css("color","#EE5269" );}else{ $("#to_address_red").css("color","green" );}
  if(to_subject==''){ $("#to_sub_red").css("color","#EE5269" );}else{ $("#to_sub_red").css("color","green" );}
  if(total_with_vat==''){ $("#total_with_vat").css({"background-color":"#EE5269","color":"#fff"});}else{ $("#total_with_vat").css({"background-color":"green","color":"#fff"} );}
  if(takainword==''){ $("#takainword").css({"background-color":"#EE5269","color":"#fff"});}else{ $("#takainword").css({"background-color":"green","color":"#fff"} );}
  if(to_name=='' || to_quotation_date=='' || to_address=='' || to_subject=='' || total_with_vat=='' || takainword==''){
     $("#msg_failed").css({"display":"block","background-color":"#EE5269"}).fadeOut(8000).html(" You have must fill out <b>red mark</b>!"); 
  }
  else
  {
    //AJAX code to submit form.
    $.ajax({
      type: "POST",
      url: "controller/create_quotation_controller.php",
      data: dataString+data_dtls+ "&tot_row_dtls="+(i-1)+'&action=save_data',
      cache: false,
      success: function(result)
      { 
        $("#msg_success").css({"display":"block","background-color":"#1E8A2B"}).fadeOut(8000).html(result);
        $("#txt_to_name").val('');
        $("#txt_quotation_date").val('');       
        $("#txt_to_desig").val('');
        $("#txt_to_address").val(''); 
        $("#total_with_vat").val('');
        $("#takainword").val('');
         show_datas();
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
      url: "controller/create_quotation_controller.php",
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
			url: "controller/create_quotation_controller.php",
			data:  'idd=' + id +'&action=getdata',			
			dataType: "json",   //expect html to be returned   
			cache: false,				
			success: function(results){										
				 //alert (results['id']);
         show_detail_form(results['id']);
/*var len = results.length;
for (var i = 0; i < len; i++) {
    console.log(results[i].phone);
}*/
         $("#txt_to_name").val(results['to_name']);
         $("#txt_quotation_date").val(results['quotation_date']); 
         $("#txt_to_desig").val(results['to_designation']);
         $("#cbo_to_com_name").val(results['to_company']);
         $("#txt_to_address").val(results['to_address']);
         $("#txt_to_subject").val(results['to_quotation_subject']);
         $("#subtotal").val(results['total_amount']);
         $("#vat").val(results['vat']);
		     $("#ait").val(results['ait']);
         $("#total_with_vat").val(results['total_amount_with_vat']);
         $("#takainword").val(results['total_amount_in_word']);
				 $('#update_id').val(results['id']);

         var noteData=results['notes'].split(',');
         for (var i=0; i<noteData.length;i++) {
           document.getElementById("note_"+noteData[i]).checked = true;
         }

				 $('#save').addClass('disabled', true);			 
				 $('#update').removeClass('disabled',false);
				 $('#csv_generate').removeClass('disabled',false);
         $('#print').removeClass('disabled',false);

          //for print data
          var to_name= results['to_name'];
          var to_quotation_date= results['quotation_date'];
          var to_designation=results['to_designation'];
          var to_company=results['to_company'];
          var to_address=results['to_address'];
          var to_quotation_subject=results['to_quotation_subject'];
          var total_amount=results['total_amount'];
          var vat=results['vat'];
		  var ait=results['ait'];
          var total_amount_with_vat=results['total_amount_with_vat'];
          var takainword=results['total_amount_in_word'];
          //var word=total_amount_with_vat;
          
	
			}
	});
		//});
 //});
}


//show details form
   function show_detail_form(mst_id)
    {
    //alert(mst_id);return;
      $.ajax({    //create an ajax request to load_page.php
        //: 'registered_user.php', data: "", dataType: 'json',  success: function(rows)   
      type: "POST",
      url: "controller/create_quotation_controller.php",
      data:  'mst_id=' + mst_id +'&action=show_detail_form',    
      dataType: "json",   //expect html to be returned 
      //dataType: "html",   
      cache: false,       
      success: function(rows){ 
      var update_var='';  
      var sl=1;
      for (var i in rows)
    {
      var row = rows[i]; 
      var sll=sl++;         
      var id = row[0];
      var mst_id = row[1];
      var item_name = row[2];
      var width_fee = row[3];
      var width_inc = row[4];   
      var height_fee = row[5];
      var height_inc = row[6];
      var total_sqft = row[7];
      var price_per_unit = row[8];
      var amount = row[9];
	  var q_qtyy = row[16];

	  var width_feet ="";
      var width_inch ="";
      var height_feet ="";
      var height_inch ="";
      var q_qty ="";

      if(width_fee>0){width_feet=width_fee} else {}
      if(width_inc>0){width_inch=width_inc} else {}
      if(height_fee>0){height_feet=height_fee} else {}
      if(height_inc>0){height_inch=height_inc} else {}
      if(q_qtyy>0){q_qty=q_qtyy} else {}
  //add_break_down_tr(sl++);
var incentive_counter=1;
//alert (incentive_counter);
 update_var += '$("#tbl_quotation_id tbody")'+'<tr id="tbl_tr_id">'+
              '<td width="5px">'+
                '<input  class="form-control" type="text" id="sl_'+sll+'" name="sl[]" value="'+sll+'" readonly>'+
              '</td>'+
              '<td>'+
			  	'<select style="margin-left:2px;" class="form-control" id="txtItem_'+sll+'" name="txtItem[]">'+
				 '<option value="'+item_name+'">'+item_name+'</option>'+
				' <?php
                  $sql="select id,task_name from lib_task_entry where status_active=1 and is_deleted=0";
                  $sql_qry=mysql_query($sql);
                  $j=1;
                  while($row=mysql_fetch_array($sql_qry)){
                  ?>'+
				  
				   '<option value="<?php echo $row['task_name']; ?>"><?php echo $row['task_name']; ?></option>'+
                  '<?php
                  $j++;
                  }
                 ?>'+
              '</select>'+ 
                //'<input  class="form-control" type="text" id="txtItem_'+sll+'" name="txtItem[]" value="'+item_name+'" placeholder="particular name">'+
              '</td>'+
              '<td>'+
                '<input style="width:55px;float:left;" class="form-control" type="text" id="txtHeightFeet_'+sll+'" name="txtHeightFeet_1[]" value="'+width_feet+'"  onKeyUp="calculate_hw();" placeholder="feet">'+
                '<input style="width:55px;" class="form-control" type="text" id="txtHeightInch_'+sll+'" name="txtHeightInch_1[]" value="'+width_inch+'"  onKeyUp="calculate_hw();" placeholder="inch">'+
              '</td>'+
              '<td>'+
                '<input style="width:55px;float:left;" class="form-control" type="text" id="txtWidthFeet_'+sll+'" name="txtWidthFeet_1[]" value="'+height_feet+'"  onKeyUp="calculate_hw();" placeholder="feet">'+
                '<input style="width:55px;" class="form-control" type="text" id="txtWidthInch_'+sll+'" name="txtWidthInch_1[]" value="'+height_inch+'"  onKeyUp="calculate_hw();" placeholder="inch">'+
              '</td>'+
              '<td>'+
                '<input class="form-control" type="text" id="txtSqrft_'+sll+'" name="txtSqrft[]" style="width:110px;text-align:right;" value="'+total_sqft+'"  onKeyUp="calculate_hw();" placeholder="total sqft" >'+
              '</td>'+
              '<td>'+
                '<input class="form-control" type="text" id="txtPrice_'+sll+'" name="txtPrice[]" style="width:110px;text-align:right;" value="'+price_per_unit+'" onKeyUp="calculate_hw();" placeholder="price per unit">'+
              '</td>'+
			  
			  '<td>'+
                '<input class="form-control" type="text" id="txtQty_'+sll+'" name="txtQty[]" style="width:110px;text-align:right;" value="'+q_qty+'" onKeyUp="calculate_hw();" placeholder="Quantity">'+
              '</td>'+
			  
              '<td>'+
                '<input class="form-control" type="text" id="txtUnitTotalPrice_'+sll+'" name="txtUnitTotalPrice[]" style="width:140px;text-align:right;" value="'+amount+'"  onKeyUp="calculate_hw();" placeholder="amount" readonly>'+
              '</td>'+
              '<td>'+
                '<input style="width:35px;height:35px;float:left;background-color:#4CAF50;font-weight:bolder;color:#fff;"type="button" id="increase_'+sll+'" name="increase[]"  class="formbuttonplasminus" value="+"'+' onClick="add_break_down_tr(\'' + sll + '\')"'+' />'+
                '<input style="width:35px;height:35px;background-color:#EE5269;font-weight:bolder;color:#fff;" type="button" id="decrease_'+sll+'" name="decrease[]" class="formbuttonplasminus" value="-" onClick="javascript:fn_deletebreak_down_tr(\'' + sll + '\')"'+' />'+
              '</td>'+
            '</tr>';


       /* update_var += "<tr>"+"<td><b>sl: </b>"+sll+"</td>"
        +"<td><b>id: </b>"+id+"</td><td><b> mst_id: </b>"+mst_id+"</td><td><b> item_name: </b>"+item_name
        +"</td><td><b> width_feet: </b>"+width_feet+"</td><td><b> width_inch: </b>"+width_inch
        +"</td><td><b> height_feet: </b>"+height_feet+"</td><td><b> height_inch: </b>"+height_inch
        +"</td><td><b> total_sqft: </b>"+total_sqft+"</td><td><b> price_per_unit: </b>"+price_per_unit
        +"</td><td><b> amount: </b>"+amount
        +"</td><tr>";*/
                  
    } 
        $("#update_tbdy_id").empty().append(update_var);
        
        }
 
    //show_list_view(mst_id,'show_detail_form','bonus_policy_tbody','requires/bonus_policy_controller','');

  });
    //});
 //});
}




// Update data by submit button function
function data_update(){
	//$(document).ready(function(){  
	// $("#submit").click(function(){
  var to_quotation_date  = $("#txt_quotation_date").val();
  var to_name         = $("#txt_to_name").val();
  var to_designation  = $("#txt_to_desig").val();
  var to_company      = $("#cbo_to_com_name").val();
  var to_address      = $("#txt_to_address").val();
  var to_subject      = $("#txt_to_subject").val();
  var total_amount    = $("#subtotal").val();
  var vat             = $("#vat").val();
  var ait             = $("#ait").val();
  var total_with_vat  = $("#total_with_vat").val();
  var takainword      = $("#takainword").val();
  var update_id 	  = $("#update_id").val();

    //notes
    var noteArray=[];
    $("input:checkbox[name=note]:checked").each(function(){
        noteArray.push($(this).val());
    });
    var noteStr = noteArray.join(",");
    //alert(noteStr);return;

	// Returns successful data submission message when the entered information is stored in database.
  var dataString = '&to_quotation_date='+ to_quotation_date + '&to_name='+ to_name + '&to_designation='+ to_designation + '&to_company='+ to_company + '&to_address='+ to_address + '&to_subject='+ to_subject + '&total_amount='+ total_amount + '&vat='+ vat + '&ait='+ ait + '&total_with_vat='+ total_with_vat + '&takainword='+ takainword + '&update_id='+ update_id + '&noteStr='+ noteStr ;
 
  var row_count=$('#tbl_quotation_id tbody tr').length;
  //alert(row_count);return;
  var data_dtls="";

  for( var i = 1; i <= row_count; i++ )
  {
  
      data_dtls+="&txtItem_" + i + "=" + $('#txtItem_'+i).val()+""+"&txtHeightFeet_" + i + "=" 
            + $('#txtHeightFeet_'+i).val()+""+"&txtHeightInch_" + i + "=" + $('#txtHeightInch_'+i).val()+""+"&txtWidthFeet_" 
            + i + "=" + $('#txtWidthFeet_'+i).val()+""+"&txtWidthInch_" + i + "=" + $('#txtWidthInch_'+i).val()+""+"&txtSqrft_" 
            + i + "=" + $('#txtSqrft_'+i).val()+""+"&txtPrice_" + i + "=" + $('#txtPrice_'+i).val()+""+"&txtQty_" 
			+ i + "=" + $('#txtQty_'+i).val()+""+"&txtUnitTotalPrice_" + i + "=" + $('#txtUnitTotalPrice_'+i).val()+"";

  }
  //alert(data_dtls);
/*   if(to_name==''||to_designation==''){
          $("#msg_failed").css({"display":"block","background-color":"#EE5269"}).fadeOut(8000).html(" You have must fill out <b>red * mark</b>!"); 
  }*/
  if(to_name==''){ $("#to_name_red").css("color","#EE5269" );}else{ $("#to_name_red").css("color","green" );}
  //if(to_designation==''){ $("#to_desi_red").css("color","#EE5269" );}else{ $("#to_desi_red").css("color","green" );}
  if(to_quotation_date==''){$("#quotation_date_red").css("color","#EE5269" );}else{$("#quotation_date_red").css("color","green" );}
  if(to_address==''){ $("#to_address_red").css("color","#EE5269" );}else{ $("#to_address_red").css("color","green" );}
  if(to_subject==''){ $("#to_sub_red").css("color","#EE5269" );}else{ $("#to_sub_red").css("color","green" );}
  if(total_with_vat==''){ $("#total_with_vat").css({"background-color":"#EE5269","color":"#fff"});}else{ $("#total_with_vat").css({"background-color":"green","color":"#fff"} );}
  if(takainword==''){ $("#takainword").css({"background-color":"#EE5269","color":"#fff"});}else{ $("#takainword").css({"background-color":"green","color":"#fff"} );}
  if(to_name=='' || to_quotation_date=='' || to_address=='' || to_subject=='' || total_with_vat=='' || takainword==''){
     $("#msg_failed").css({"display":"block","background-color":"#EE5269"}).fadeOut(8000).html(" You have must fill out <b>red mark</b>!"); 
  }
  else
  {
    //AJAX code to submit form.
		$.ajax({
			type: "POST",
			url: "controller/create_quotation_controller.php",
      data: dataString+data_dtls+ "&tot_row_dtls="+(i-1)+'&action=update_data',
      cache: false,
			success: function(result)
			{	
  				 //alert(result);
  			$("#msg_success").css({"display":"block","background-color":"#1E8A2B"}).fadeOut(8000).html(result);
        $("#txt_to_name").val('');
        $("#txt_quotation_date").val('');  
        $("#txt_to_desig").val('');
        $("#txt_to_address").val(''); 
        $("#total_with_vat").val('');
        $("#takainword").val('');
         show_datas();
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
			url: "controller/create_quotation_controller.php",
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
 //$('#print').addClass('disabled',true);
}
 
function load_address()
{
var com_id=$('#cbo_to_com_name').val();
//alert(com_id);
	  $.ajax({    //create an ajax request to load_page.php
			type: "GET",
			url: "controller/create_quotation_controller.php",
			data:  'com_idd=' + com_id +'&action=getaddress',			
			dataType: "json",   //expect html to be returned   
			cache: false,				
			success: function(results){	
				 //alert (results['id']);
				 $('#txt_to_address').val(results['address']);
				 $('#txt_to_short_name').val(results['short_name']);
				
			}
	});
		//});
 //});
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
            $( "#txt_quotation_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
            //$( "#txt_delivery_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
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
<script type="text/javascript">
var current = document.getElementById('default');

  function highlite(el)
  {
     if (current != null)
     {
         current.className = "";
     }
     el.className = "highlite";
     current = el;
  }
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

.quotation input{
  background-color:#FDFDC0; 
}
.quotation th
{
	text-align:center;
}
.form-group{
  font-size: 12px;
}
/* horizontal menu style */
#navv {
	width:100%;
	list-style:none;
	margin-left:200px;
}
#navv li{
display:inline;
}
#navv a {
	color:black;
	text-decoration:none;
	outline:0;
	background-color:#CCCCCC;
	padding:10px;
}
#navv a:active, #navv a:focus, #navv a:hover {
	color:red; 
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
            <a href="commercial_home.php"><button class="dropbtn">commercial</button></a>
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
  <div class="page_path" style="float:left;">Commercial / Create Quotation</div>
  <div class="pagename" style="float:right;">Page: Quotation</div><hr/>

    <div id="mySidenav" class="sidenav">
      <a href="javascript:void(0)" class="closebtn" onClick="closeNav()">&times;</a>
      
         <li><a href="create_quotation.php">Create quotation</a></li>
         <li><a href="order_entry.php">Order Entry</a></li>
         <li><a href="create_bill.php">Create bill</a></li>
         <li><a href="create_challan.php">Create challan</a></li> 
      
     
  </div>
  <span style="font-size:20px;cursor:pointer; float:left;" onClick="openNav()">&#9776; menu</span>
  
  <div class="horizontal_menu" style="float:left; text-align:center;">  
	<ul id="navv">
	  <li><a id="default" class="highlite" onClick="highlite(this);" href="create_quotation.php">Create quotation</a></li>
	  <li><a onClick="highlite(this);" href="order_entry.php">Order Entry</a></li>
	  <li><a onClick="highlite(this);" href="create_bill.php">Create bill</a></li>
	  <li><a onClick="highlite(this);" href="create_challan.php">Create challan</a></li>
	</ul>
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

<div class="quotation">
<div class="container-fluid">
  <div class="col-md-12" id="hide_print_section" style="background-color:#fff;margin-top:5px;">
          <h2>Price Quotaton Creation generate / update form</h2>
          
    <div class="row">
      <div class="col-md-12">
        <h1  style="text-align:center; font-size:20px;">Price Quotation</h1>
      </div>
      <div class="col-md-12">
      
      		<div style="float:right;">
             <div class="input-group">
              <input type="text" class="form-control" id="txt_quotation_date" name="txt_quotation_date" placeholder="Year-Month-Day">
              <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk" id="quotation_date_red"></span></span>
             </div>
            </div>
      
        <h5  style="text-align:right;"><?php //echo date("d-m-Y") ?></h5>
      </div>
    </div>
<form name="quotationFrm_1" id="quotationFrm_1" method="POST" action="">
    <div style="margin-bottom:15px;" class="row">
       <div style="padding-left:0px;" class="col-md-4">

        <p style="text-align:left;margin-bottom:-12px;margin-left:2px;font-size:15px;"><strong>To</strong></p><br/>
        <div class="form-group">
            <label class="control-label col-sm-2 col-md-2" for="to_name">Name:</label>
            <div class="col-sm-10 col-md-10">
             <div class="input-group">
              <input type="text" class="form-control" id="txt_to_name" name="txt_to_name" value="" placeholder="name">
              <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk" id="to_name_red"></span></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2 col-md-2" for="designation">Designation:</label>
            <div class="col-sm-10 col-md-10">
             <div class="input-group">
              <input type="text" class="form-control" id="txt_to_desig" name="txt_to_desig" placeholder="designation" style="width:285px;">
              <span class="input-group-addon">&nbsp;</span></span>
              </div>
            </div>
          </div>        
          <div class="form-group">
            <label class="control-label col-sm-2 col-md-2" for="to_com">Company:</label>
            <div class="col-sm-10 col-md-10">
            <div class="input-group">
              <select style="margin-left:9px;" class="form-control" id="cbo_to_com_name" name="cbo_to_com_name" onChange="load_address();">
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
			  <input type="hidden" id="txt_to_short_name" name="txt_to_short_name">
              <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk" id="to_client_red"></span></span>
              </div>
            </div>
          </div>        
           <div class="form-group">
            <label class="control-label col-sm-2 col-md-2" for="address">Address:</label>
            <div class="col-sm-10 col-md-10">
             <div class="input-group">
              <input type="text" class="form-control" id="txt_to_address" name="txt_to_address" placeholder="address">
              <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk" id="to_address_red"></span></span>
              </div>
            </div>
          </div>
      </div>
      <div style="float:right;" class="col-md-4">
        <p style="text-align:right;">
        From<br/>
        <strong>Sajib Rahman</strong><br/>
        Chief Executive Officer (CEO)<br/>
        Out of Home (OH)<br/>
        63, Banani, Dhaka-1213<br/>
        </p>
      </div>
    </div>
    <div class="row" style="margin-bottom:15px;">
      <div class="col-md-7" style=" margin-left:-15px;">
       
          <div class="form-group">
            <label class="control-label col-sm-1 col-md-1" for="sub">Subject:</label>
            <div class="col-sm-10 col-md-10">
             <div class="input-group" style="margin-left:10px;">
              <input type="text" class="form-control" id="txt_to_subject" name="txt_to_subject" placeholder="subject">
              <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk" id="to_sub_red"></span></span>
              </div>
            </div>
          </div>
         <input type="hidden" id="update_id" name="update_id">  
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
       <table class="table" id="tbl_quotation_id">
          <thead>
            <tr style="background-color:#E2EBFF;">
            <th width="5px">SL</th>
            <th width="200px">Particular</th>
            <th width="140px">Width</th>
            <th width="140px">Height</th>
            <th width="100px">Total Sqft / Pcs</th>
            <th width="100px">Price per unit</th>
			<th width="80px">Qty</th>
            <th width="140px">Amount</th>
            <th width="100px">Action</th>
            </tr>
            <tr style="background-color:#D5E2FF;">
            <th colspan="2"></th>
            <th>Feet | Inch</th>
            <th>Feet | Inch</th>
            <th colspan="5"></th>
            </tr>
          </thead>
          <tbody id="update_tbdy_id">
            <tr id="tbl_tr_id">
              <td width="5px">
                <input  class="form-control" type="text" id="sl_1" name="sl[]" value="1" readonly>
              </td>
              <td>
			   <select style="margin-left:2px;" class="form-control" id="txtItem_1" name="txtItem[]">
			   
                  <?php
                  $sql="select id,task_name from lib_task_entry where status_active=1 and is_deleted=0";
                  $sql_qry=mysql_query($sql);
                  $j=1;
                  while($row=mysql_fetch_array($sql_qry)){
                  ?>
                  <option value="<?php echo $row['task_name']; ?>"><?php echo $row['task_name']; ?></option>
                  <?php
                  $j++;
                  }
                  ?>
              </select> 
               <!-- <input  class="form-control" type="text" id="txtItem_1" name="txtItem[]" value="" placeholder="particular name">-->
              </td>
              <td>
                <input style="width:55px;float:left;" class="form-control" type="text" id="txtHeightFeet_1" name="txtHeightFeet_1[]" value=""  onKeyUp="calculate_hw();" placeholder="feet">
                <input style="width:55px;" class="form-control" type="text" id="txtHeightInch_1" name="txtHeightInch_1[]" value=""  onKeyUp="calculate_hw();" placeholder="inch">
              </td>
              <td>
                <input style="width:55px;float:left;" class="form-control" type="text" id="txtWidthFeet_1" name="txtWidthFeet_1[]" value=""  onKeyUp="calculate_hw();" placeholder="feet">
                <input style="width:55px;" class="form-control" type="text" id="txtWidthInch_1" name="txtWidthInch_1[]" value=""  onKeyUp="calculate_hw();" placeholder="inch">
              </td>
              <td>
                <input class="form-control" type="text" id="txtSqrft_1" name="txtSqrft[]" style="width:110px;text-align:right;" value=""  onKeyUp="calculate_hw();"  placeholder="total sqft/Pcs" >
              </td>
              <td>
                <input class="form-control" type="text" id="txtPrice_1" name="txtPrice[]" style="width:110px;text-align:right;" value="" onKeyUp="calculate_hw();" placeholder="price per unit">
              </td>
			  
			  <td>
                <input class="form-control" type="text" id="txtQty_1" name="txtQty[]" style="width:110px;text-align:right;" value="1"  onKeyUp="calculate_hw();" placeholder="Quantity" >
              </td>
			  
			  
              <td>
                <input class="form-control" type="text" id="txtUnitTotalPrice_1" name="txtUnitTotalPrice[]" style="width:140px;text-align:right;" value=""  onKeyUp="calculate_hw();" placeholder="amount" readonly>
              </td>
              <td>
                <input style="width:35px;height:35px;float:left;background-color:#4CAF50;font-weight:bolder;color:#fff;" type="button" id="increase_1" name="increase[]"  class="formbuttonplasminus" value="+" onClick="add_break_down_tr(1)" />
                <input style="width:35px;height:35px;background-color:#EE5269;font-weight:bolder;color:#fff;" type="button" id="decrease_1" name="decrease[]" class="formbuttonplasminus" value="-" onClick="javascript:fn_deletebreak_down_tr(1);" />
              </td>
            </tr>
          </tbody>
          <tfoot>                                           
            <tr>
              <td colspan="6"></td>
              <td style="text-align:right;">Total Amount Tk.</td>
              <td style="text-align:center;"><input class="form-control" style="width:140px;text-align:right;" type="text" id="subtotal" onKeyUp="calculate_hw();" readonly></td>
              <td></td>           
            </tr>
            <tr>
              <td colspan="6"></td>
              <td style="text-align:right;">Vat</td>
              <td style="text-align:center;"><input class="form-control" style="width:140px;text-align:right;" type="text" id="vat" onKeyUp="calculate_hw();"></td>
              <td>%</td>           
            </tr>
			<tr>
              <td colspan="6"></td>
              <td style="text-align:right;">AIT</td>
              <td style="text-align:center;"><input class="form-control" style="width:140px;text-align:right;" type="text" id="ait" onKeyUp="calculate_hw();"></td>
              <td>%</td>           
            </tr>
            <tr>
              <td colspan="6"></td>
              <td style="text-align:right;">Total Amount Tk (Including VAT/AIT)</td>
              <td style="text-align:center;"><input class="form-control" style="width:140px;text-align:right;" type="text" id="total_with_vat" onKeyUp="calculate_hw();" readonly></td>
              <td></td>           
            </tr>         
          </tfoot>
          
        </table>
</div>  
      </div>
<!--</form>-->
             
 <p style="text-align:left; margin-top:-6px;font-size:17px;"><b style="float:left;">Taka in word:</b><input class="form-control" style="width:640px;text-align:left;float:left; border:none;background-color:#FFFFFF;border-color:#fff;" readonly type="text" id="takainword" onKeyUp="calculate_hw();"></p>
 <br/>
 <p style="text-align:left; margin-top:-6px;font-size:14px;"><b>Note:</b> 
 <div style="margin-top:-40px;">
<?php
	
	foreach ($notes_arr as $key => $note) {
		?>
		<input style="margin-left:-50px; margin-right:-90px;" type="checkbox" name="note" id="note_<?php echo $key; ?>" value="<?php echo $key; ?>"> <?php echo $note; ?><br/>
		<?php
	}

?>
</div>
 </p>
            

              <div class="col-sm-5 col-md-offset-5">
                 <div class="input-group">
                    <button type="button" class="btn btn-default" id="save" onClick="data_send();">Create</button>
                    <button type="button" class="btn btn-default disabled" id="update" onClick="data_update();">Update</button>          
                    <button type="reset" class="btn btn-default" onClick="active_save_btn();">Reset</button>
                    <button type="button" class="btn btn-default disabled" id="csv_generate" onClick="fnc_csv_generate();">CSV</button> 
                    <!--<button type="button" class="btn btn-primary disabled" id="print" onClick="data_print(1);">Print</button> -->                
                </div>
              </div>
              </form>
         <div class="col-md-12">
            <p style="background-color:#f9f9f9;color:#fff; display:none;" id="msg_success"></p>
            <p style="background-color:#f3f3f3;;color:#fff; display:none;" id="msg_failed"></p>
         </div>

    </div>

  </div>

<script type="text/javascript">
/*	
*/

</script>

      <div class="col-md-12">
       <h2>Quotation list</h2>
      <p><span class="glyphicon glyphicon-search search-boxs"></span><input type="text" id="search_user_create" placeholder="search" onKeyUp="fnc_search();"></p>
      <div id="data_table_container"></div>
      </div>
</div>
        
       
       <?php
        //return library company
$return_lib_cmp=fnc_pickup_data_from_db_table("id,company_name","lib_client_entry","is_deleted=0"); 
$return_lib_company_arr=array();
foreach($return_lib_cmp as $aa)
  {
    $return_lib_company_arr[$aa[0]] =$aa[1]; //$aa=['id'].
  }
    //echo $return_lib_company_arr[2];
       ?> 
      
	
<script type="text/javascript">
//add row function (+)
   function add_break_down_tr(i)
    {
      //alert(i);
        var row_num = $('#tbl_quotation_id tbody tr').length;
        if ( row_num != i )
        {
            return false;
        }
    
        else
        {
      
            i++;
       
            $("#tbl_quotation_id tbody tr:last").clone().find("input,select").each(function()
      {
                 $(this).attr({
                    'id': function(_, id) 
          {
                        var id = id.split("_");
            //alert(id);
                        return id[0] + "_" + i
                    },
                    'name': function(_, name) 
          {
                        return name
                    },
                    'value': function(_, value)
          {
                        return value
                    },
          'src': function(_, src)
          {
                        return src
            
                    }
                });
            }).end().appendTo("#tbl_quotation_id tbody");
            $('#increase_' + i).removeAttr("onClick").attr("onClick", "add_break_down_tr(" + i + ");");
      //$( '#txtCusLcDate_'+i ).removeClass( "datepicker hasDatepicker" ).addClass( "datepicker" );
            $('#decrease_' + i).removeAttr("onClick").attr("onClick", "fn_deletebreak_down_tr(" + i + ");");
            $('#sl_'+i).val(i);
            $('#txtItem_' + i).val('');
            $('#txtHeightFeet_' + i).val('');
            $('#txtHeightInch_' + i).val('');
            $('#txtWidthFeet_' + i).val('');
            $('#txtWidthInch_' + i).val('');
            $('#txtSqrft_' + i).val('');      
            $('#txtPrice_' + i).val('');
			$('#txtQty_' + i).val(1);
            $('#txtUnitTotalPrice_' + i).val('');
            //$('#updatedtlsid_' + i).val('');
      //set_all_onclick();
        }
    }
//remove row function (-)
function fn_deletebreak_down_tr(rowNo, table_id)
    {
        var numRow = $('table#tbl_quotation_id tbody tr').length;
        if (numRow == rowNo && rowNo != 1)
        {
            $('#tbl_quotation_id tbody tr:last').remove();
            calculate_hw();
        }
    }
// onKeyup="calculate_hw();"
  function calculate_hw() // h*w,unit*price,total_unit_price
  {
        //alert();
        var row_count=$('#tbl_quotation_id tbody tr').length;
        //alert(row_count);return;
        var multidata = 0;
        for( var i = 1; i <= row_count; i++ )
        {
          //h*w
          var h_feet=$("#txtHeightFeet_"+i).val()*1;
          var h_inch=$("#txtHeightInch_"+i).val()*1;
          var w_feet=$("#txtWidthFeet_"+i).val()*1;
          var w_inch=$("#txtWidthInch_"+i).val()*1;
		
           //for pcs calculation
          if (h_feet=="" && h_inch=="" && w_feet=="" && w_inch=="") 
          	{
          		 var pcs=$("#txtSqrft_"+i).val()*1;
          		 var price=$("#txtPrice_"+i).val()*1;
          		 var multi_unitprice= (pcs*price);
          		 $("#txtUnitTotalPrice_"+i).val(number_format(multi_unitprice,2));
          		 $("#txtQty_"+i).val(" ");
          		 $('#txtQty_'+i).attr('readonly',true);
          	}
          	
          	else
          	{
          	
          	$('#txtQty_'+i).attr('readonly',false);
	          var h_fi=h_feet+(h_inch/12);
	          var w_fi=w_feet+(w_inch/12);
	          //calculate widht*height
	          var multi_hw=w_fi*h_fi;
	          $("#txtSqrft_"+i).val(number_format(multi_hw,2)); 
	          //calculate total sqft*price unit
	          var unit_price=$("#txtPrice_"+i).val()*1;			  
			  var qty=$("#txtQty_"+i).val()*1;			  
	          var multi_unitprice=unit_price*multi_hw*qty;
			 // var multi_unitprice_qty=multi_unitprice*qty;			  
	          $("#txtUnitTotalPrice_"+i).val(number_format(multi_unitprice,2));
	          //$('#txtSqrft_'+i).attr('readonly',true);
         	} 
          //calculate subtotal
          multidata += multi_unitprice;
          //calculate vat
          var get_vat=$("#vat").val()*1;
          var cal_vat=(multidata/100)*get_vat;
		  
		  //calculate AIT
          var get_ait=$("#ait").val()*1;
          var cal_ait=(multidata/100)*get_ait;
          //calculate vat+ait+total
         $("#total_with_vat").val(number_format(cal_ait+cal_vat+multidata));

        }
          $("#subtotal").val(number_format(multidata,2));
           var inword=$("#total_with_vat").val();
           //alert(inWords(inword));
           var inword=number_format(inword,"","","");
          $("#takainword").val(inWords(inword)); 
  }

 //print function..................................................................................
  function data_print(dprint)
  {
    if (dprint==1) {
      //$(".fltrow").hide();
      var w = window.open("Surprise", "#");
      var d = w.document.open();
      w.document.write('<!DOCTYPE html>'+'<html><head><title>Price Quotation Print!</title><link rel="stylesheet" type="text/css" href="../css/style_print.css"></head><body>'+'<button id="print_btn" onclick="window.print();"> Print </button>'+document.getElementById('hide_print_section').innerHTML+'</body></html>');
      //d.write ('<!DOCTYPE html>'+'<html><head><title>print price quotation</title><link rel="stylesheet" type="text/css" href="style.css" media="print" /></head><body>'+document.getElementById('report_container2').innerHTML+'</body></html>');
      //$(".fltrow").show();
      //'<html><head><title>print price quotation</title><link rel="stylesheet" href="../../../css/style_common.css" type="text/css" media="print" /></head><body>'+document.getElementById('report_container2').innerHTML+'</body</html>');

      d.close();
    };
    
  }

  //----------------------
  function print_function(id)
  {
      query_data_print(id);
       
  }
        //get data for update
        function query_data_print(id){
          $.ajax({    //create an ajax request to load_page.php
            type: "GET",
            url: "controller/create_quotation_controller.php",
            data:  'idd=' + id +'&action=getdata',      
            dataType: "json",   //expect html to be returned   
            cache: false,       
            success: function(results){                   
               //alert (results['id']);
               show_detail_form_report(results['id']);
            var com_lib_array = <?php echo json_encode($return_lib_company_arr); ?>;
            var   to_name= results['to_name'];
            var   to_quotation_date= results['quotation_date'];
            var   to_desig= results['to_designation'];
            var   to_com_name =com_lib_array[results['to_company']];
            var   to_address=results['to_address'];
            var   to_subject=results['to_quotation_subject'];
            var   total_amount=results['total_amount'];
            var   vat=results['vat'];
			var   ait=results['ait'];
            var   total_amount_with_vat=results['total_amount_with_vat'];
            var   takainword=results['total_amount_in_word'];


            /*
            var noteData=results['notes'].split(',');
            var printThis = "";
            for(var i = 0; i < noteData.length; i++){
                printThis += "<br>"+pausecontent[noteData[i]];
            }
			*/
                   
            //date
            var quotation_date = new Date(to_quotation_date); var dd = quotation_date.getDate(); var mm = quotation_date.getMonth()+1; var yyyy = quotation_date.getFullYear(); if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} var quotation_date = dd+'/'+mm+'/'+yyyy; 
            var d = new Date();
            var month = d.getMonth()+1;
            var day = d.getDate();
            var output =  ((''+day).length<2 ? '0' : '') + day + '/'+
                ((''+month).length<2 ? '0' : '') + month + '/' +
                d.getFullYear();
                //end date

var add_ait="";               
if(ait>0)
{
	var add_ait='<tr><td colspan="6" style="text-align:right;padding-right:5px;">AIT %</td><td style="text-align:right;padding-right:5px;border:1px solid black;">'+ait+'</td></tr>';
}
var add_vat="";              
if(vat>0)
{
	var add_vat='<tr><td colspan="6" style="text-align:right;padding-right:5px;">VAT %</td><td style="text-align:right;padding-right:5px;border:1px solid black;">'+vat+'</td></tr>';
}

var add_desig="";
if(to_desig!="")
{
   var add_desig=to_desig+'<br>';
}
            $('#print').removeClass('disabled',false); 

            $("#hide_print_section").empty().append('<div class="col-md-12" style="background-color:#fff;">'+
    '</div>'+
    '<div class="col-md-12">'+
      '<h4 style="text-align:center;">Quotation</h4>'+
    '</div>'+
    '<div class="col-md-12">'+
      '<h4 style="text-align:right;" id="qdate">Date:'+quotation_date+'</h4>'+
    '</div>'+
    '<div class="col-md-12" style="text-align:left;background-color:#fff; ">'+
      '<b>To</b><br>'+
      to_name+'<br>'+
      add_desig+
      to_com_name+'<br>'+
      to_address+'<br><br>'+
      '<b>Subject: </b>' + to_subject+
      '<table style="margin-top:10px;border-collapse:collapse;">'+
        '<thead>'+
          '<tr>'+
            '<th style="width:50px;text-align:center;border:1px solid black;">SL</th>'+
            '<th style="width:350px;text-align:center;border:1px solid black;">Particulars</th>'+
            '<th style="width:150px;text-align:center;border:1px solid black;">Size</th>'+
            '<th style="width:120px;text-align:center;border:1px solid black;">Total Sqft / Pcs</th>'+
            '<th style="width:100px;text-align:center;border:1px solid black;">Unit Price</th>'+
            '<th style="width:100px;text-align:center;border:1px solid black;"text-align:center;>Qty</th>'+
            '<th style="width:120px;text-align:center;border:1px solid black;">Amount</th>'+
          '</tr>'+    
        '</thead>'+
        '<tbody id="update_tbdy_id">'+
          '<tr>'+
            '<td style="text-align:center;">01</td>'+
            '<td style="text-align:left;">Main singboard</td>'+
            '<td style="text-align:right;">10ft X 5inch</td>'+
            '<td style="text-align:right;">15ft X 11inch</td>'+
            '<td style="text-align:right;">600</td>'+
            '<td style="text-align:right;">1568</td>'+
            '<td style="text-align:right;">1568</td>'+
          '</tr>'+
        '</tbody>'+
        //'<tfoot>'+
          '<tr>'+
            '<td colspan="6" style="text-align:right;padding-right:5px;">Sub Total Amount Tk</td>'+
            '<td style="text-align:right;padding-right:5px;border:1px solid black;"><b>'+total_amount+'</b></td>'+
          '</tr>'+
		  add_vat+		 
		  add_ait+		 
          '<tr>'+
            '<td colspan="6" style="text-align:right;padding-right:5px;">Total Amount Tk</td>'+
            '<td style="text-align:right;padding-right:5px;border:1px solid black;"><b>'+total_amount_with_vat+'</b></td>'+
          '</tr>'+
          '<tr>'+
         ' </tr>'+
        //'</tfoot>'+
      '</table>'+
      '<div class="col-md-12">'+
        '<p style="text-align:left;"><b>Taka In Word: </b>' + takainword+'</p>'+
      '</div>'+
      '<div id="notess" class="col-md-12">'+
        '<p style="text-align:left;"><b>Note: </b>'+'</p>'+
       
      '</div>'+
      '<div class="col-md-12" style="margin-top:100px;">'+
        '<div class="col-md-4" style="float:left;">'+
          '<p style="text-align:left;"><b>Receiver'+'\''+'s Signature</b></p>'+
        '</div>'+
        '<div class="col-md-4" style="float:right;">'+
          '<p style="text-align:left;"><b>OH (Out of Home)</b></p>'+
        '</div>'+
        '<div class="col-md-4">'+
          '<button type="button" class="btn btn-primary" id="print" onClick="data_print(1);">Print Quotation</button> '+
          '<a href="create_quotation.php"><button type="button" class="btn btn-danger">Close Quotation</button></a> '+
        '</div>'+
     '</div>'+
    '</div>');             
            }
        });
      }
      //show details form
   function show_detail_form_report(mst_id)
    {
    //alert(mst_id);return;
      $.ajax({    //create an ajax request to load_page.php
        //: 'registered_user.php', data: "", dataType: 'json',  success: function(rows)   
      type: "POST",
      url: "controller/create_quotation_controller.php",
      data:  'mst_id=' + mst_id +'&action=show_detail_form',    
      dataType: "json",   //expect html to be returned 
      //dataType: "html",   
      cache: false,       
      success: function(rows){ 
      var update_varr='';  
      var sl=1;
      for (var i in rows)
    {
      var row = rows[i]; 
      var sll=sl++;         
      var id = row[0];
      var mst_id = row[1];
      var item_name = row[2];
      var width_fee = row[3];
      var width_inc = row[4];
      var height_fee = row[5];
      var height_inc = row[6];
      var total_sqft = row[7];
      var price_per_unit = row[8];
      var amount = row[9];
	  var q_qtyy = row[16];
        

 	  var width_feet ="";
      var width_inch ="";
      var height_feet ="";
      var height_inch ="";
      var q_qty ="";

      if(width_fee>0){width_feet=width_fee; width_feet=width_feet + '\'' ;} else {}
      if(width_inc>0){width_inch=width_inc; width_inch=width_inch +'\"' ;} else {}
      if(height_fee>0){height_feet=height_fee; height_feet= ' x ' + height_feet + '\'' ;} else {}
      if(height_inc>0){height_inch=height_inc; height_inch=height_inch +'\"' ;} else {}
      if(q_qtyy>0){q_qty=q_qtyy;} else {}


//var incentive_counter=1;
//alert (incentive_counter);
 update_varr += '$("#tbl_quotation_id tbody")'+'<tr id="tbl_tr_id">'+
            '<td style="text-align:center;border:1px solid black;">'+sll+'</td>'+
            '<td style="text-align:left;border:1px solid black;">'+item_name+'</td>'+
            '<td style="text-align:center;border:1px solid black;">'+width_feet  + width_inch + height_feet  + height_inch +'</td>'+
            '<td style="text-align:center;border:1px solid black;">'+total_sqft+'</td>'+
            '<td style="text-align:right;padding-right:5px;border:1px solid black;">'+price_per_unit+'</td>'+
            '<td style="text-align:right;padding-right:5px;border:1px solid black;">'+q_qty+'</td>'+
            '<td style="text-align:right;padding-right:5px;border:1px solid black;">'+amount+'</td>'+
            '</tr>';


       /* update_var += "<tr>"+"<td><b>sl: </b>"+sll+"</td>"
        +"<td><b>id: </b>"+id+"</td><td><b> mst_id: </b>"+mst_id+"</td><td><b> item_name: </b>"+item_name
        +"</td><td><b> width_feet: </b>"+width_feet+"</td><td><b> width_inch: </b>"+width_inch
        +"</td><td><b> height_feet: </b>"+height_feet+"</td><td><b> height_inch: </b>"+height_inch
        +"</td><td><b> total_sqft: </b>"+total_sqft+"</td><td><b> price_per_unit: </b>"+price_per_unit
        +"</td><td><b> amount: </b>"+amount
        +"</td><tr>";*/
                  
    } 
        $("#update_tbdy_id").empty().append(update_varr);
        
        }
 
    //show_list_view(mst_id,'show_detail_form','bonus_policy_tbody','requires/bonus_policy_controller','');

  });
    //});
 //});
}
//action for Generrate CSV file
function fnc_csv_generate()
{
	 var update_id1 = $("#update_id").val();
	 $.ajax({   
      type: "GET",
      url: "controller/create_quotation_controller.php",
	  data:  'update_id1=' + update_id1 +'&action=csv_export',  
      dataType: "html",   
      cache: false,       
      success: function(response){ 
      //$("#data_table_container").html(response);
	  var response=response.split('***')         
      $("#msg_success").css({"display":"block","background-color":"#1E8A2B"}).fadeOut(8000).html(response[1]); 
      }
      });
}

</script>


</body>
</html>
