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
 	isset($_POST['to_name']) && 
 	isset($_POST['to_designation']) && 
 	isset($_POST['to_company'])&&
	isset($_POST['to_address']) &&
	isset($_POST['to_subject']) &&
	isset($_POST['total_amount']) &&
	isset($_POST['vat']) && 
 	isset($_POST['total_with_vat'])&&
 	isset($_POST['takainword'])&&
	isset($_POST['tot_row_dtls'])
	//isset($_POST['data_dtls'])
 	//isset($_POST['contact1'])
 	){
	$action_save		=$_POST['action'];
	$to_name2			=$_POST['to_name'];
	$to_designation2	=$_POST['to_designation'];
	$to_company2		=$_POST['to_company'];
	$to_address2		=$_POST['to_address'];
	$to_subject2		=$_POST['to_subject'];
	$total_amount2		=$_POST['total_amount'];
	$vat2				=$_POST['vat'];
	$total_with_vat2	=$_POST['total_with_vat'];
	$takainword2		=$_POST['takainword'];
	$tot_row_dtls		=$_POST['tot_row_dtls'];
	//generate quotaion number OH+Q+returnNextId+Date
	$generate_quotation_date=date('d-m-y');
  	$quotation_number_generate=return_next_id("id", "com_create_quotation_mst", "1");
  	$quotation_number_generate='OH-Q-'.$quotation_number_generate.'-'.$generate_quotation_date;

	$id= return_next_id("id", "com_create_quotation_mst", "1");
	$field_array_cus_lc 	= "mst_id,item_name,width_feet,width_inch,height_feet,height_inch,total_sqft,price_per_unit,amount,inserted_by,insert_date";
	if($action_save=="save_data")
	{
	  	$query = mysql_query("insert into com_create_quotation_mst(to_name,to_designation,to_company,to_address,to_quotation_subject,total_amount,vat,total_amount_with_vat,quotation_date,total_amount_in_word,quotation_number_generate,insert_date,inserted_by) values
		('$to_name2','$to_designation2','$to_company2','$to_address2','$to_subject2','$total_amount2','$vat2','$total_with_vat2','$only_today_date','$takainword2','$quotation_number_generate','$insert_and_update_date','$login_session_user_id')");
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
			//echo "insert into com_create_quotation_dtls (".$field_array_cus_lc.") values ".$data_array_cus_lc;
			if($query==1 && $query2==1){
			echo $msg_save;		
			//echo "<h4>Success:</h4> You have created <b>user successfully</b>!";
			}
			else{
	  		echo $msg_save_fail;
			//echo "<h4>Failed:</h4> You have not created <b>user</b>!";
		  }
	}
}

//return library company
$return_lib_cmp=fnc_pickup_data_from_db_table("id,company_name","lib_client_entry","is_deleted=0"); 
$return_lib_company_arr=array();
foreach($return_lib_cmp as $aa)
	{
		$return_lib_company_arr[$aa[0]] =$aa[1]; //$aa=['id'].
	}
		//echo $return_lib_company_arr[2];
// show list view action start here
if(isset($_GET['action'])){
	 $action_view_data= $_GET['action'];
	// echo $actions;
	if($action_view_data=="list_view")
	{
		$i=0;
		$result=mysql_query("select * from com_create_quotation_mst where is_deleted=0 and status_active=1 order by id DESC");
		?>
		<table class="table table-hover">
		<thead>
		  <tr>		 
			<th>sl</th>
			<th>Quotation Number</th>
			<th>sender name</th>		
			<th>designation</th>
			<th>company</th>
			<th>subject</th>
			<th>date</th>
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
      	<td align="center"><?php echo $data[11]; ?></td>
        <td align="center"><?php echo $data[1]; ?></td>
		<td align="center"><?php echo $data[2]; ?></td>
		<td align="center"><?php echo $return_lib_company_arr[$data[3]]; ?></td>
		<td align="center"><?php echo $data[5]; ?></td>
		<td align="center"><?php echo change_date_format($data[9],"dd-mm-yyyy","-",''); ?></td>
		<td align="center"><?php echo $data[8]; ?></td>		
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
		$sql= mysql_query("select * from com_create_quotation_mst where id=$idd");
		
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
		$result=mysql_query("select * from com_create_quotation_mst where to_name='$search_value2' and is_deleted=0 and status_active=1 order by id DESC");
		?>
		<table class="table table-hover">
    <thead>
      <tr>		 
		<th>sl</th>
		<th>Quotation Number</th>
		<th>sender name</th>
		<th>designation</th>
		<th>company</th>
		<th>subject</th>
		<th>date</th>
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
      	<td align="center"><?php echo $data[11]; ?></td>
        <td align="center"><?php echo $data[1]; ?></td>
		<td align="center"><?php echo $data[2]; ?></td>
		<td align="center"><?php echo $return_lib_company_arr[$data[3]]; ?></td>
		<td align="center"><?php echo $data[5]; ?></td>
		<td align="center"><?php echo change_date_format($data[9],"dd-mm-yyyy","-",''); ?></td>
		<td align="center"><?php echo $data[8]; ?></td>		
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

?>