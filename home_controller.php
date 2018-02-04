<?php 
// session 
session_start();
include('include/db_connection.php');
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
header('Location:index.php'); // Redirecting To Home Page
}
//end session
include('include/kaiyum_function.php');
include('include/common_function.php');
include('include/array_function.php');
include('include/message_function.php');



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
	  		,job_number_generate,production_status,delivery_date,challan_no,bill_no,bill_status from com_order_entry where is_deleted=0 and status_active=1 order by id DESC");
		?>
		<table class="table table-hover">
		<thead>
		  <tr style="background-color:#459A49; color:#fff;">
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
			<th>Challan No</th>
			<th>Bill No</th>
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
		<td><?php echo get_extra_code($data[5]); ?></td>
		<td><?php echo change_date_format($data[6],"dd-mm-yyyy","-",''); ?></td>		
		<td><?php echo $data[7]; ?></td>
		<td><?php echo $production_status[$data[8]]; ?></td>
		<td><?php echo change_date_format($data[9],"dd-mm-yyyy","-",''); ?></td>
		<td><?php echo $data[10]; ?></td>		
		<td><?php echo $data[11]; ?></td>
		<td><?php echo $bill_status[$data[12]]; ?></td>
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


?>