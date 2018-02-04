<?php 
// session 
session_start();
include('../../include/db_connection.php');
//session start
$user_check=$_SESSION['login_user'];
//SQL Query To Fetch Complete Information Of User
$ses_sql=mysql_query("select * from admin_user_create where user_name='$user_check'");
$row = mysql_fetch_assoc($ses_sql);
$login_session_user_id 		=$row['id'];
$login_session_username 	=$row['user_name'];
$login_session_useremail 	=$row['user_email'];
$login_session_usertype 	=$row['user_type'];
if(!isset($login_session_user_id)){
mysql_close($connection); // Closing Connection
header('Location: ../../index.php'); // Redirecting To Home Page
}
//end session
include('../../include/kaiyum_function.php');
include('../../include/common_function.php');
include('../../include/array_function.php');
include('../../include/message_function.php');

//action=save_data,Fetching Values from URL
if(	isset($_POST['action']) &&
 	isset($_POST['to_subject']) &&
 	isset($_POST['hidden_quotation_id'])&&
	isset($_POST['hidden_short_name'])&&
 	isset($_POST['hidden_order_id'])
	//isset($_POST['data_dtls'])
 	//isset($_POST['contact1'])
 	){
	$action_save		=$_POST['action'];
	$to_subject2		=$_POST['to_subject'];
	$hidden_quotation_id2=$_POST['hidden_quotation_id'];
	$hidden_order_id2	=$_POST['hidden_order_id'];
	$hidden_short_name2	=$_POST['hidden_short_name'];
	//$tot_row_dtls		=$_POST['tot_row_dtls'];
	//generate quotaion number OH+Q+returnNextId+Date
	$generate_challan_date=date('d-m-y');
  	$challan_number_generate=return_next_id("id", "com_create_challan_mst", "1");
  	$challan_number_generate='OH-'.$hidden_short_name2.'-CHL-'.$challan_number_generate.'-'.$generate_challan_date;
	/*$id= return_next_id("id", "com_create_quotation_mst", "1");
	$field_array_cus_lc 	= "mst_id,item_name,width_feet,width_inch,height_feet,height_inch,total_sqft,price_per_unit,amount,inserted_by,insert_date";
	*/
	if($action_save=="save_data")
	{
	  	$query = mysql_query("insert into com_create_challan_mst(quotation_mst_id,order_mst_id,challan_number_generate,challan_subject,challan_date,insert_date,inserted_by) 
	  		values('$hidden_quotation_id2','$hidden_order_id2','$challan_number_generate','$to_subject2','$only_today_date','$insert_and_update_date','$login_session_user_id')");
	  	/*
	  	$data_array_cus_lc="";
		//dtls
			for($i=1; $i<=$tot_row_dtls; $i++)
			{	
				$txtItem				=$_POST["txtItem_".$i];
				$txtHeightFeet 			=$_POST["txtHeightFeet_".$i];
				$txtHeightInch 			=$_POST["txtHeightInch_".$i];
				$txtWidthFeet 			=$_POST["txtWidthFeet_".$i];
				$txtWidthInch			=$_POST["txtWidthInch_".$i];
				$txtSqrft 				=$_POST["txtSqrft_".$i];
				$txtPrice 				=$_POST["txtPrice_".$i];
				$txtUnitTotalPrice 		=$_POST["txtUnitTotalPrice_".$i];
				//echo "10**".$LcDate;die;

				if($data_array_cus_lc!="") $data_array_cus_lc.=",";
				$data_array_cus_lc.="(".$id.",'".$txtItem."','".$txtWidthFeet."','".$txtWidthInch."','".$txtHeightFeet."','".$txtHeightInch."','".$txtSqrft."','".$txtPrice."','".$txtUnitTotalPrice."',".$login_session_user_id.",'".$insert_and_update_date."')";
				//$id=$id+1;
			} 
			$query2 = mysql_query("insert into com_create_quotation_dtls ($field_array_cus_lc) values ".$data_array_cus_lc);
			*/
			//echo "insert into com_create_quotation_dtls (".$field_array_cus_lc.") values ".$data_array_cus_lc;
			if($query==1){
			echo $msg_save;		
			//echo "<h4>Success:</h4> You have created <b>user successfully</b>!";
			}
			else{
	  		echo $msg_save_fail;
			//echo "<h4>Failed:</h4> You have not created <b>user</b>!";
		  }
	}
}

//Update data
//Fetching Values from URL
if(	isset($_POST['action']) &&
	isset($_POST['to_subject']) &&
	isset($_POST['update_id1'])  
 	){
	$action_update		=$_POST['action'];
	$to_subject2		=$_POST['to_subject'];
	$update_id2			=$_POST['update_id1'];

	if($action_update=="update_data")
	{
	//update query 
	  $query_update = mysql_query("update com_create_challan_mst SET challan_subject='$to_subject2',update_date='$insert_and_update_date',updated_by='$login_session_user_id' where id='$update_id2'");
	  if($query_update==1){
	  	echo $msg_update;
		//echo "<h4>Success:</h4> Data update <b>user successfully</b>!";
	  }
	  else{
	  		echo $msg_update_fail;
			//echo "<h4>Failed:</h4> data update <b>field</b>!";
		  }
	}
}
//return library generate order number
$return_lib_order_no=fnc_pickup_data_from_db_table("id,order_number_generate","com_order_entry","is_deleted=0"); 
$return_lib_order_arr=array();
foreach($return_lib_order_no as $aa)
	{
		$return_lib_order_arr[$aa[0]] =$aa[1]; //$aa=['id'].
	}
//return library generate quotation number
$return_lib_quotation_no=fnc_pickup_data_from_db_table("id,quotation_number_generate","com_create_quotation_mst","is_deleted=0"); 
$return_lib_quotation_arr=array();
foreach($return_lib_quotation_no as $aa)
	{
		$return_lib_quotation_arr[$aa[0]] =$aa[1]; //$aa=['id'].
	}
//return library company
$return_lib_cmp=fnc_pickup_data_from_db_table("id,company_name","lib_client_entry","is_deleted=0"); 
$return_lib_company_arr=array();
foreach($return_lib_cmp as $aa)
	{
		$return_lib_company_arr[$aa[0]] =$aa[1]; //$aa=['id'].
	}
		//echo $return_lib_company_arr[2];
//return library task
$return_lib_task=fnc_pickup_data_from_db_table("id,task_name","lib_task_entry","is_deleted=0"); 
$return_lib_task_arr=array();
foreach($return_lib_task as $aa)
	{
		$return_lib_task_arr[$aa[0]] =$aa[1]; //$aa=['id'].
	}
		//echo $return_lib_task_arr[2];
// show list view action start here
if(isset($_GET['action'])){
	 $action_view_data= $_GET['action'];
	// echo $actions;
	if($action_view_data=="list_view")
	{
		$i=0;
		$result=mysql_query("select a.id as challan_id,a.challan_number_generate,a.challan_subject,a.challan_date,a.order_mst_id,b.id as quotaion_id,b.to_company,b.total_amount_with_vat from com_create_challan_mst a,com_create_quotation_mst b where a.quotation_mst_id=b.id order by a.id DESC");
		?>
		<table class="table table-hover scroll">
		<thead>
		  <tr>		 
			<th>sl</th>
			<th>challan number</th>
			<th>challan subject</th>		
			<th>challan date</th>
			<th>order number</th>
			<th>quotation number</th>
			<th>company</th>
			<th>total amount</th>
			<th>Action</th>
		  </tr>
		</thead>
    <tbody>
    <?php
    while($data = mysql_fetch_row($result))
	{   
		$i++;
	?>
      <tr style="cursor: pointer;">
      	<td align="center"><?php echo $i; ?></td>
      	<td align="center"><?php echo $data[1]; ?></td>
        <td align="center"><?php echo $data[2]; ?></td>
		<td align="center"><?php echo change_date_format($data[3],"dd-mm-yyyy","-",''); ?></td>
		<td align="center"><a href="order_entry.php" target="_blank"><?php echo $return_lib_order_arr[$data[4]]; ?></a></td>
		<td align="center"><a href="create_quotation.php" target="_blank"><?php echo $return_lib_quotation_arr[$data[5]]; ?></a></td>
		<td align="center"><?php echo $return_lib_company_arr[$data[6]]; ?></td>
		<td align="center"><?php echo $data[7]; ?></td>		
        <td align="center">
        	<span class="glyphicon glyphicon-edit" onclick="get_data_from_list(<?php echo $data[0]; ?>)";></span> |
         	<span class="glyphicon glyphicon-trash" onclick="fnc_delete(<?php echo $data[0]; ?>)";></span> |
         	<span class="glyphicon glyphicon-print" onclick="print_function(<?php echo $data[0]; ?>)";></span>
        </td>
      </tr>
   <?php
  	}
  	?>
    </tbody>
  </table>
<?php
 	
	}
}

// Get data from database and populate data to form for update
if(isset($_GET['action'])){
	
	 $action_data_populate_to_form = $_GET['action'];
	 if($action_data_populate_to_form =="getdata")
	 {
		 
		$idd=$_GET['idd'];
		//(to_name,to_designation,to_company,to_address,to_quotation_subject,total_amount,vat,total_amount_with_vat,quotation_date,total_amount_in_word,quotation_number_generate,insert_date,inserted_by
		$sql= mysql_query("select a.id as challan_id,a.challan_subject,a.quotation_mst_id as quotation_id,b.to_name,b.to_designation,b.to_company,b.to_address,b.total_amount,b.vat,b.total_amount_with_vat,b.total_amount_in_word from com_create_challan_mst a,com_create_quotation_mst b where a.id=$idd and a.quotation_mst_id=b.id");
		
		while($result = mysql_fetch_assoc($sql)) {
			echo json_encode($result);
		}

		/*while($result = mysql_fetch_assoc($sqll)) {
			echo json_encode($result);
		}*/
		 
	 }
}
// Pick up data for ORDER from database and populate data to form for Order informations
if(isset($_GET['action'])){
	
	 $action_data_populate_to_form = $_GET['action'];
	 if($action_data_populate_to_form =="getdata_order")
	 {
		 
		$idd=$_GET['idd'];
		$sql= mysql_query("select a.id as quotationId,a.to_name,a.to_company,a.to_address,a.to_designation,a.to_quotation_subject,a.total_amount,a.total_amount_with_vat,a.vat,a.total_amount_in_word,b.id as orderId,c.short_name from com_create_quotation_mst a,com_order_entry b,lib_client_entry c where b.id=$idd and b.quotation_no=a.id and a.to_company=c.id");
		
		while($result = mysql_fetch_assoc($sql)) {
			echo json_encode($result);
		}

		/*while($result = mysql_fetch_assoc($sqll)) {
			echo json_encode($result);
		}*/
		 
	 }
}
if(isset($_POST['action'])){
	$action = $_POST['action'];
	if ($action=="show_detail_form")
{
	$mst_id=$_POST['mst_id'];
	$data_array= mysql_query("select * from com_create_quotation_dtls where mst_id=$mst_id");
	$data = array();
	while($result = mysql_fetch_row($data_array)) {
		  $data[] = $result;
			
		}
		echo json_encode($data);
	//$data_array=sql_select("select id,policy_id,slot,confirmation,percentage,base_head,amount_type from lib_bonus_policy_definition where policy_id='$data'");

}
}

// Search  list view  data table action start here
if(isset($_GET['action']) && isset($_GET['search_value1'])){
	 $action_search	= $_GET['action'];
	 $search_value2	= $_GET['search_value1'];//$_GET['search_value1'];
	// echo $actions;
	if($action_search=="search_list_view")
	{
		$i=0;
		
		
		$result=mysql_query("select a.id as challan_id,a.challan_number_generate,a.challan_subject,a.challan_date,a.order_mst_id,b.id as quotaion_id,b.to_company,b.total_amount_with_vat from com_create_challan_mst a,com_create_quotation_mst b where a.quotation_mst_id=b.id and a.challan_number_generate='$search_value2' order by a.id DESC");
		?>
		<table class="table table-hover">
    <thead>
      <tr>		 
		<th>sl</th>
		<th>challan number</th>
		<th>challan subject</th>		
		<th>challan date</th>
		<th>order number</th>
		<th>quotation number</th>
		<th>company</th>
		<th>total amount with vat</th>
		<th>Action</th>
	  </tr>
    </thead>
    <tbody>
    <?php
    while($data = mysql_fetch_row($result))
	{   
		$i++;
	?>

	 <tr style="cursor: pointer;">
      	<td align="center"><?php echo $i; ?></td>
      	<td align="center"><?php echo $data[1]; ?></td>
        <td align="center"><?php echo $data[2]; ?></td>
		<td align="center"><?php echo change_date_format($data[3],"dd-mm-yyyy","-",''); ?></td>
		<td align="center"><a href="order_entry.php" target="_blank"><?php echo $data[4]; ?></a></td>
		<td align="center"><a href="create_quotation.php" target="_blank"><?php echo $data[5]; ?></a></td>
		<td align="center"><?php echo $return_lib_company_arr[$data[6]]; ?></td>
		<td align="center"><?php echo $data[7]; ?></td>		
        <td align="center">
        	<span class="glyphicon glyphicon-edit"  onclick="get_data_from_list(<?php echo $data[0]; ?>)";></span> |
         	<span class="glyphicon glyphicon-trash" onclick="fnc_delete(<?php echo $data[0]; ?>)";></span> |
         	<span class="glyphicon glyphicon-print" onclick="print_function(<?php echo $data[0]; ?>)";></span>
        </td>
      </tr>
   <?php
  	}
  	?>
    </tbody>
  </table>
<?php
 	
	}
}



// show list view ORDER action start here
if(isset($_GET['action'])){
	 $action_view_data= $_GET['action'];
	// echo $actions;
	if($action_view_data=="list_view_order")
	{
		$i=0;
		$result=mysql_query("select id,order_number_generate,order_date,client_name,task_name,quotation_no,quotation_date,job_number_generate,production_status,delivery_date,bill_status from com_order_entry where is_deleted=0 and status_active=1 order by id DESC");
		?>
		<table class="table table-hover scroll">
		<thead>
		  <tr>		 
			<th>SL</th> 	
			<th>Order No</th>
			<th>Order Date</th> 	
			<th>Client Name</th> 	
			<th>Task Type</th>
			<th>Quotation No</th>
			<th>Quotation Date</th> 
			<th>Job No</th>
			<th>Production Status</th>
			<th>Delivery Date</th>
			<th>Bill Status</th>
			<th>Action</th>
		  </tr>
		</thead>
    <tbody>
    <?php
    while($data = mysql_fetch_row($result))
	{   
		$i++;
	?>
      <tr style="cursor: pointer;">
      	<td align="center"><?php echo $i; ?></td>            
		<td align="center"><a href="order_entry.php" target="_blank"><?php echo $data[1]; ?></a></td>
		<td align="center"><?php echo change_date_format($data[2],"dd-mm-yyyy","-",''); ?></td>
		<td align="center"><?php echo $return_lib_company_arr[$data[3]]; ?></td>
		<td align="center"><?php echo $return_lib_task_arr[$data[4]]; ?></td>
		<td align="center"><a href="create_quotation.php" target="_blank"><?php echo $return_lib_quotation_arr[$data[5]]; ?></a></td>
		<td align="center"><?php echo change_date_format($data[6],"dd-mm-yyyy","-",''); ?></td>		
		<td align="center"><?php echo $data[7]; ?></td>
		<td align="center"><?php echo $production_status[$data[8]]; ?></td>
		<td align="center"><?php echo change_date_format($data[9],"dd-mm-yyyy","-",''); ?></td>
		<td align="center"><?php echo $bill_status[$data[10]]; ?></td>
        <td align="center"><span class="glyphicon glyphicon-import" onclick="get_data_from_list_order(<?php echo $data[0]; ?>)";></span></td>
      </tr>
   <?php
  	}
  	?>
    </tbody>
  </table>
<?php
 	
	}
}

// Search  list view ORder data table action start here
if(isset($_GET['action']) && isset($_GET['search_value1'])){
	 $action_search	= $_GET['action'];
	 $search_value2	= $_GET['search_value1'];//$_GET['search_value1'];
	// echo $actions;
	if($action_search=="search_list_view_order")
	{
		$i=0;
		$result=mysql_query("select id,order_number_generate,order_date,client_name,task_name,quotation_no,quotation_date,job_number_generate,production_status,delivery_date,bill_status from com_order_entry where is_deleted=0 and status_active=1 and order_number_generate='$search_value2' order by id DESC");
		?>
		<table class="table table-hover">
    <thead>
      <tr>		 
		<th>SL</th> 
			<th>Order No</th>
			<th>Order Date</th> 	
			<th>Client Name</th> 	
			<th>Task Type</th>
			<th>Quotation No</th>
			<th>Quotation Date</th> 
			<th>Job No</th>
			<th>Production Status</th>
			<th>Delivery Date</th>
			<th>Bill Status</th>
			<th>Action</th>
	  </tr>
    </thead>
    <tbody>
    <?php
    while($data = mysql_fetch_row($result))
	{   
		$i++;
	?>

	 <tr style="cursor: pointer;">
      	<td align="center"><?php echo $i; ?></td>            
		<td align="center"><?php echo $data[1]; ?></td>
		<td align="center"><?php echo change_date_format($data[2],"dd-mm-yyyy","-",''); ?></td>
		<td align="center"><?php echo $return_lib_company_arr[$data[3]]; ?></td>
		<td align="center"><?php echo $return_lib_task_arr[$data[4]]; ?></td>
		<td align="center"><?php echo $return_lib_quotation_arr[$data[5]]; ?></td>
		<td align="center"><?php echo change_date_format($data[6],"dd-mm-yyyy","-",''); ?></td>		
		<td align="center"><?php echo $data[7]; ?></td>
		<td align="center"><?php echo $production_status[$data[8]]; ?></td>
		<td align="center"><?php echo change_date_format($data[9],"dd-mm-yyyy","-",''); ?></td>
		<td align="center"><?php echo $bill_status[$data[10]]; ?></td>
        <td align="center"><span class="glyphicon glyphicon-import" onclick="get_data_from_list_order(<?php echo $data[0]; ?>)";></span></td>
      </tr>
   <?php
  	}
  	?>
    </tbody>
  </table>
<?php
 	
	}
}
?>