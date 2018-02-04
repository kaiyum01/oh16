<?php 
// session 
session_start();
include('../../include/db_connection.php');
//session start
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
header('Location: ../../index.php'); // Redirecting To Home Page
}
//end session
include('../../include/kaiyum_function.php');
include('../../include/common_function.php');
include('../../include/array_function.php');
include('../../include/message_function.php');

//action=save_data,Fetching Values from URL
if(	isset($_POST['action']) &&
	//isset($_POST['order_no1']) &&
	isset($_POST['order_date1']) &&
	isset($_POST['client_name1']) &&
	isset($_POST['short_name1']) &&
	isset($_POST['task_type1']) &&
	isset($_POST['quotation_no1']) &&
	isset($_POST['quotation_date1']) &&
	//isset($_POST['job_no1']) &&
	isset($_POST['production_status1']) &&
	isset($_POST['delivery_date1']) &&
	//isset($_POST['challan_no1']) &&
	//isset($_POST['bill_no1']) &&
	isset($_POST['bill_status1'])

 	//isset($_POST['contact1'])
 	){
	$action_save	=$_POST['action'];
	//$order_no2 		=$_POST['order_no1'];
	$order_date2 	=$_POST['order_date1'];
	$client_name2 	=$_POST['client_name1'];
	$short_name2 	=$_POST['short_name1'];
	$task_type2 	=$_POST['task_type1'];
	$quotation_no2 	=$_POST['quotation_no1'];
	$quotation_date2 =$_POST['quotation_date1'];
	//$job_no2 		=$_POST['job_no1'];
	$production_status2 =$_POST['production_status1'];
	$delivery_date2 =$_POST['delivery_date1'];
	//$challan_no2 	=$_POST['challan_no1'];
	//$bill_no2 		=$_POST['bill_no1'];
	$bill_status2 	=$_POST['bill_status1'];
	//generate order number OH+ORD+returnNextId+Date
	$generate_order_date=date('d-m-y');
  	$order_number_generate=return_next_id("id", "com_order_entry", "1");
  	$order_number_generate='OH-'.$short_name2.'-ORD-'.$order_number_generate.'-'.$generate_order_date;

	//generate job number OH+JOB+returnNextId+Date
	$generate_job_date=date('d-m-y');
  	$job_number_generate=return_next_id("id", "com_order_entry", "1");
  	$job_number_generate='OH-'.$short_name2.'-JOB-'.$job_number_generate.'-'.$generate_job_date;


	if($action_save=="save_data")
	{
	  	$query = mysql_query("insert into com_order_entry(order_number_generate,order_date,client_name,task_name,quotation_no,quotation_date
	  		,job_number_generate,production_status,delivery_date,bill_status,insert_date,inserted_by) values ('$order_number_generate','$order_date2',
	  		'$client_name2','$task_type2','$quotation_no2','$quotation_date2','$job_number_generate','$production_status2','$delivery_date2','$bill_status2','$insert_and_update_date','$login_session_user_id')");
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
//return library quotation
$return_lib_quotation=fnc_pickup_data_from_db_table("id,quotation_number_generate","com_create_quotation_mst","is_deleted=0"); 
$return_lib_quotation_arr=array();
foreach($return_lib_quotation as $aa)
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
		$result=mysql_query("select id,order_number_generate,order_date,client_name,task_name,quotation_no,quotation_date
	  		,job_number_generate,production_status,delivery_date,bill_status from com_order_entry where is_deleted=0 and status_active=1 order by id DESC");
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
			<!--<th>Quotation Date</th> -->
			<th>Job No</th>
			<th>Status</th>
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
      	<td><?php echo $i; ?></td>            
		<td><?php echo $data[1]; ?></td>
		<td><?php echo change_date_format($data[2],"dd-mm-yyyy","-",''); ?></td>
		<td><?php echo $return_lib_company_arr[$data[3]]; ?></td>
		<td><?php echo $return_lib_task_arr[$data[4]]; ?></td>
		<td><a href="create_quotation.php" target="_blank"><?php echo $return_lib_quotation_arr[$data[5]]; ?></a></td>
		<!--<td><?php //echo change_date_format($data[6],"dd-mm-yyyy","-",''); ?></td>		-->
		<td><?php echo $data[7]; ?></td>
		<td><?php echo $production_status[$data[8]]; ?></td>
		<td><?php echo change_date_format($data[9],"dd-mm-yyyy","-",''); ?></td>
		<td><?php echo $bill_status[$data[10]]; ?></td>
        <td><span class="glyphicon glyphicon-edit" onclick="get_data_from_list(<?php echo $data[0]; ?>)";></span> | <span class="glyphicon glyphicon-trash" onclick="fnc_delete(<?php echo $data[0]; ?>)";></span></td>
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
		$sql= mysql_query("select id,order_number_generate,order_date,client_name,task_name,quotation_no,quotation_date
	  		,job_number_generate,production_status,delivery_date,bill_status from com_order_entry where is_deleted=0 and status_active=1 and id=$idd");
		while($result = mysql_fetch_assoc($sql)) {
			echo json_encode($result);
		}
		 
	 }
}
//Update data
//Fetching Values from URL
if(	isset($_POST['action']) &&
	isset($_POST['order_date1']) &&
	isset($_POST['client_name1']) &&
	isset($_POST['task_type1']) &&
	isset($_POST['quotation_no1']) &&
	isset($_POST['quotation_date1']) &&
	isset($_POST['production_status1']) &&
	isset($_POST['delivery_date1']) &&
	//isset($_POST['challan_no1']) &&
	//isset($_POST['bill_no1']) &&
	isset($_POST['bill_status1']) &&
	isset($_POST['update_id1'])   
 	//isset($_POST['contact1'])
 	){
	$action_update	=$_POST['action'];
	$order_date2 	=$_POST['order_date1'];
	$client_name2 	=$_POST['client_name1'];
	$task_type2 	=$_POST['task_type1'];
	$quotation_no2 	=$_POST['quotation_no1'];
	$quotation_date2 =$_POST['quotation_date1'];
	$production_status2 =$_POST['production_status1'];
	$delivery_date2 =$_POST['delivery_date1'];
	//$challan_no2 	=$_POST['challan_no1'];
	//$bill_no2 		=$_POST['bill_no1'];
	$bill_status2 	=$_POST['bill_status1'];
	$update_id2		=$_POST['update_id1'];
	
	if($action_update=="update_data")
	{
	//update query 

	  $query_update = mysql_query("update com_order_entry SET order_date='$order_date2',
	  	client_name='$client_name2',task_name='$task_type2',quotation_no='$quotation_no2',quotation_date='$quotation_date2',production_status='$production_status2',delivery_date='$delivery_date2',bill_status='$bill_status2',update_date='$insert_and_update_date',
	  	updated_by='$login_session_user_id' where id='$update_id2'");
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
// Pick up data for QUOTATION from database and populate data to form for Order informations
if(isset($_GET['action'])){
	
	 $action_data_populate_to_form = $_GET['action'];
	 if($action_data_populate_to_form =="getdata_quotation")
	 {
		 
		$idd=$_GET['idd'];
		$sql= mysql_query("select a.id,a.quotation_number_generate,a.quotation_date,a.to_company,b.short_name from com_create_quotation_mst a,lib_client_entry b where a.id=$idd and a.to_company=b.id");
		
		while($result = mysql_fetch_assoc($sql)) {
			echo json_encode($result);
		}

		/*while($result = mysql_fetch_assoc($sqll)) {
			echo json_encode($result);
		}*/
		 
	 }
}
//-------------------
	// Delete action
if(isset($_POST['action'])){
	 $action_delete= $_POST['action'];//$_POST['action'];
	 if($action_delete=="delete_data_action")
	 {
		$delete_id=$_POST['delete_id'];
		$sql_delete= mysql_query("update com_order_entry SET status_active=0, is_deleted=1,update_date='$insert_and_update_date',updated_by='$login_session_user_id' where id='$delete_id'");
		if($sql_delete==1)
		{
			echo $msg_delete;
		}
		else
		{
			echo $msg_delete_fail;
		}
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
		$result=mysql_query("select id,order_number_generate,order_date,client_name,task_name,quotation_no,quotation_date
	  		,job_number_generate,production_status,delivery_date,bill_status from com_order_entry where order_number_generate='$search_value2' and is_deleted=0 and status_active=1 order by id DESC");
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
      </tr>
    </thead>
    <tbody>
    <?php
    while($data = mysql_fetch_row($result))
	{   
		$i++;
	?>
      <tr style="cursor: pointer;">
      	<td><?php echo $i; ?></td>            
		<td><?php echo $data[1]; ?></td>
		<td><?php echo change_date_format($data[2],"dd-mm-yyyy","-",''); ?></td>
		<td><?php echo $return_lib_company_arr[$data[3]]; ?></td>
		<td><?php echo $return_lib_task_arr[$data[4]]; ?></td>
		<td><a href="create_quotation.php" target="_blank"><?php echo $return_lib_quotation_arr[$data[5]]; ?></a></td>
		<td><?php echo change_date_format($data[6],"dd-mm-yyyy","-",''); ?></td>		
		<td><?php echo $data[7]; ?></td>
		<td><?php echo $production_status[$data[8]]; ?></td>
		<td><?php echo change_date_format($data[9],"dd-mm-yyyy","-",''); ?></td>
		<td><?php echo $bill_status[$data[10]]; ?></td>
        <td><span class="glyphicon glyphicon-edit" onclick="get_data_from_list(<?php echo $data[0]; ?>)";></span> | <span class="glyphicon glyphicon-trash" onclick="fnc_delete(<?php echo $data[0]; ?>)";></span></td>
      </tr>
   <?php
  	}
  	?>
    </tbody>
  </table>
<?php
 	
	}
}
// show list view QUOTATION action start here
if(isset($_GET['action'])){
	 $action_view_data= $_GET['action'];
	// echo $actions;
	if($action_view_data=="list_view_quotation")
	{
		$i=0;
		$result=mysql_query("select id,quotation_number_generate,quotation_date,to_name,to_company,to_quotation_subject,total_amount_with_vat from com_create_quotation_mst where is_deleted=0 and status_active=1 order by id DESC");
		?>
		<table class="table table-hover scroll">
		<thead>
		  <tr>		 
			<th>SL</th> 	
			<th>Quotation No</th>
			<th>Quotation Date</th>
			<th>person name</th> 	
			<th>company Name</th> 	
			<th>Quotation subject</th>
			<th>Total Amount</th>
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
      	<td><?php echo $i; ?></td>            
		<td align="center"><a href="create_quotation.php" target="_blank"><?php echo $data[1]; ?></a></td>
		<td align="center"><?php echo change_date_format($data[2],"dd-mm-yyyy","-",''); ?></td>
		<td align="center"><?php echo $data[3]; ?></td>
		<td align="center"><?php echo $return_lib_company_arr[$data[4]]; ?></td>
		<td align="center"><?php echo $data[5]; ?></td>
		<td align="center"><?php echo $data[6]; ?></td>		
        <td align="center"><span class="glyphicon glyphicon-import" onclick="get_data_from_list_quotation(<?php echo $data[0]; ?>)";></span></td>
      </tr>
   <?php
  	}
  	?>
    </tbody>
  </table>
<?php
 	
	}
}

// Search  list view QUOTATION data table action start here
if(isset($_GET['action']) && isset($_GET['search_value1'])){
	 $action_search	= $_GET['action'];
	 $search_value2	= $_GET['search_value1'];//$_GET['search_value1'];
	// echo $actions;
	if($action_search=="search_list_view_quotation")
	{
		$i=0;
		$result=mysql_query("select id,quotation_number_generate,quotation_date,to_name,to_company,to_quotation_subject,total_amount_with_vat from com_create_quotation_mst where is_deleted=0 and status_active=1 and quotation_number_generate='$search_value2' order by id DESC");
		?>
		<table class="table table-hover scroll">
    <thead>
      <tr>		 
		<th>SL</th> 	
		<th>Quotation No</th>
		<th>Quotation Date</th>
		<th>person name</th> 	
		<th>company Name</th> 	
		<th>Quotation subject</th>
		<th>Total Amount</th>
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
		<td align="center"><?php echo $data[3]; ?></td>
		<td align="center"><?php echo $return_lib_company_arr[$data[4]]; ?></td>
		<td align="center"><?php echo $data[5]; ?></td>
		<td align="center"><?php echo $data[6]; ?></td>
        <td align="center"><span class="glyphicon glyphicon-import" onclick="get_data_from_list_quotation(<?php echo $data[0]; ?>)";></span></td>
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