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
	isset($_POST['to_quotation_date']) &&
 	isset($_POST['to_name']) && 
 	isset($_POST['to_designation']) && 
 	isset($_POST['to_company'])&&
	isset($_POST['to_short_company'])&&
	isset($_POST['to_address']) &&
	isset($_POST['to_subject']) &&
	isset($_POST['total_amount']) &&
	isset($_POST['vat']) && 
	isset($_POST['ait']) &&
 	isset($_POST['total_with_vat'])&&
 	isset($_POST['takainword'])&&
	isset($_POST['tot_row_dtls'])
	//isset($_POST['data_dtls'])
 	//isset($_POST['contact1'])
 	){
	$action_save		=$_POST['action'];
	$to_quotation_date2 =$_POST['to_quotation_date'];
	$to_name2			=$_POST['to_name'];
	$to_designation2	=$_POST['to_designation'];
	$to_company2		=$_POST['to_company'];
	$to_short_company2	=$_POST['to_short_company'];
	$to_address2		=$_POST['to_address'];
	$to_subject2		=$_POST['to_subject'];
	$total_amount2		=$_POST['total_amount'];
	$vat2				=$_POST['vat'];
	$ait2				=$_POST['ait'];
	$total_with_vat2	=$_POST['total_with_vat'];
	$takainword2		=$_POST['takainword'];
	$noteStr			=$_POST['noteStr'];
	$tot_row_dtls		=$_POST['tot_row_dtls'];
	//generate quotaion number OH+Q+returnNextId+Date
	$generate_quotation_date=date('m');
  	$quotation_number_generate=return_next_id("id", "com_create_quotation_mst", "1");
  	$quotation_number_generate='OH-'.$to_short_company2.'-Q-'.$generate_quotation_date.'-'.$quotation_number_generate;

	
	$field_array_cus_lc = "mst_id,item_name,width_feet,width_inch,height_feet,height_inch,total_sqft,price_per_unit,q_qty,amount,inserted_by,insert_date";
	if($action_save=="save_data")
	{
	  	$query = mysql_query("insert into com_create_quotation_mst(to_name,to_designation,to_company,to_address,to_quotation_subject,total_amount,vat,ait,total_amount_with_vat,quotation_date,total_amount_in_word,quotation_number_generate,notes,insert_date,inserted_by) values
		('$to_name2','$to_designation2','$to_company2','$to_address2','$to_subject2','$total_amount2','$vat2','$ait2','$total_with_vat2','$to_quotation_date2','$takainword2','$quotation_number_generate','$noteStr','$insert_and_update_date','$login_session_user_id')");
	  
		$id= return_next_id("id", "com_create_quotation_mst", "1");
		$id=$id-1;

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
				$txtQty 				=$_POST["txtQty_".$i];
				$txtUnitTotalPrice 		=$_POST["txtUnitTotalPrice_".$i];
				//echo "10**".$LcDate;die;

				if($data_array_cus_lc!="") $data_array_cus_lc.=",";
				$data_array_cus_lc.="(".$id.",'".$txtItem."','".$txtWidthFeet."','".$txtWidthInch."','".$txtHeightFeet."','".$txtHeightInch."','".$txtSqrft."','".$txtPrice."','".$txtQty."','".$txtUnitTotalPrice."',".$login_session_user_id.",'".$insert_and_update_date."')";
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
		<table class="table table-hover scroll">
		<thead>
		  <tr>		 
			<th>sl</th>
			<th>Quotation Number</th>
			<th>sender name</th>		
			<th>designation</th>
			<th>company</th>
			<th>subject</th>
			<th>date</th>
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
// get address
if(isset($_GET['action'])){
	 $action_address_populate_to_form = $_GET['action'];
	 if($action_address_populate_to_form =="getaddress")
	 {
		 
		$com_idd=$_GET['com_idd'];
		$sql= mysql_query("select address,short_name from lib_client_entry where id=$com_idd");
		while($result = mysql_fetch_assoc($sql)) {
			echo json_encode($result);
		}
		 
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
//Update data
//Fetching Values from URL
if(	isset($_POST['action']) &&
	isset($_POST['to_quotation_date']) &&
	isset($_POST['to_name']) && 
 	isset($_POST['to_designation']) && 
 	isset($_POST['to_company'])&&
	isset($_POST['to_address']) &&
	isset($_POST['to_subject']) &&
	isset($_POST['total_amount']) &&
	isset($_POST['vat']) && 
	isset($_POST['ait']) &&
 	isset($_POST['total_with_vat'])&&
 	isset($_POST['takainword'])&&
	isset($_POST['tot_row_dtls'])&&
	isset($_POST['update_id'])   
 	//isset($_POST['contact1'])
 	){
	$action_update		=$_POST['action'];
	$to_quotation_date2 =$_POST['to_quotation_date'];
	$to_name2			=$_POST['to_name'];
	$to_designation2	=$_POST['to_designation'];
	$to_company2		=$_POST['to_company'];
	$to_address2		=$_POST['to_address'];
	$to_subject2		=$_POST['to_subject'];
	$total_amount2		=$_POST['total_amount'];
	$vat2				=$_POST['vat'];
	$ait2				=$_POST['ait'];
	$total_with_vat2	=$_POST['total_with_vat'];
	$takainword2		=$_POST['takainword'];
	$tot_row_dtls		=$_POST['tot_row_dtls'];
	$noteStr			=$_POST['noteStr'];
	$update_id2			=$_POST['update_id'];

	//update query
	$field_array_cus_lc 	= "mst_id,item_name,width_feet,width_inch,height_feet,height_inch,total_sqft,price_per_unit,q_qty,amount,inserted_by,insert_date";
	if($action_update=="update_data")
	{
		$sql_delete = mysql_query("DELETE FROM com_create_quotation_dtls WHERE mst_id=$update_id2");
	  	$query = mysql_query("update com_create_quotation_mst SET to_name='$to_name2',to_designation='$to_designation2',to_company='$to_company2',to_address='$to_address2',to_quotation_subject='$to_subject2',total_amount='$total_amount2',vat='$vat2',ait='$ait2',total_amount_with_vat='$total_with_vat2',quotation_date='$to_quotation_date2',total_amount_in_word='$takainword2',notes='$noteStr',update_date='$insert_and_update_date',updated_by='$login_session_user_id' where id='$update_id2'");
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
				$txtQty 				=$_POST["txtQty_".$i];
				$txtUnitTotalPrice 		=$_POST["txtUnitTotalPrice_".$i];
				//echo "10**".$LcDate;die;

				if($data_array_cus_lc!="") $data_array_cus_lc.=",";
				$data_array_cus_lc.="(".$update_id2.",'".$txtItem."','".$txtWidthFeet."','".$txtWidthInch."','".$txtHeightFeet."','".$txtHeightInch."','".$txtSqrft."','".$txtPrice."','".$txtQty."','".$txtUnitTotalPrice."',".$login_session_user_id.",'".$insert_and_update_date."')";
				//$id=$id+1;
			} 
			$query2 = mysql_query("insert into com_create_quotation_dtls ($field_array_cus_lc) values ".$data_array_cus_lc);
			//echo "insert into com_create_quotation_dtls (".$field_array_cus_lc.") values ".$data_array_cus_lc;
			if($query==1 && $query2==1){
			echo $msg_update;		
			//echo "<h4>Success:</h4> You have created <b>user successfully</b>!";
			}
			else{
	  		echo $msg_update_fail;
			//echo "<h4>Failed:</h4> You have not created <b>user</b>!";
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
		$result=mysql_query("select * from com_create_quotation_mst where quotation_number_generate='$search_value2' and is_deleted=0 and status_active=1 order by id DESC");
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

<?php
//for csv export aciton
if(isset($_GET['action']) && isset($_GET['update_id1'])){
	 $action_csv	= $_GET['action'];
	 $update_id3	= $_GET['update_id1'];
	
	if($action_csv=="csv_export")
	{
		ob_start();	
		$i=0;
		// Full texts 	id 	to_name 	to_designation 	to_company 	to_address 	to_quotation_subject 	total_amount 	vat 	total_amount_with_vat 	quotation_date 	total_amount_in_word 	quotation_number_generate 	is_deleted 	status_active 	updated_by 	update_date 	insert_date 	inserted_by 	ait
		// Full texts 	id 	mst_id 	item_name 	width_feet 	width_inch 	height_feet 	height_inch 	total_sqft 	price_per_unit 	amount 	is_deleted 	status_active 	update_date 	updated_by 	inserted_by 	insert_date 	q_qty
		$result_mst=mysql_query("select id,to_name,to_designation,to_company,to_address,to_quotation_subject,
			total_amount,vat,quotation_date,ait,total_amount_with_vat,total_amount_in_word,quotation_number_generate 
		 from com_create_quotation_mst where id= $update_id3 and is_deleted=0 and status_active=1 ");
		$result_dtls=mysql_query("select id,mst_id,item_name,width_feet,width_inch,height_feet,height_inch,
			total_sqft,price_per_unit,amount,is_deleted,status_active,update_date,updated_by,
			inserted_by,insert_date,q_qty
		 from com_create_quotation_dtls where mst_id= $update_id3 and is_deleted=0 and status_active=1 ");

				     // for master table
					$array_mst = array();
				    while ($project_mst =  mysql_fetch_assoc($result_mst))
				    {
				        $array_mst[] = $project_mst;
				    }
				    ?>
				    <div style="width:100%;">
				    	

						    	<?php
								//$slNo=0; 
								$total_amount="";
								$vat="";
								$ait="";
								$total_amount_with_vat=""; 
								$total_amount_in_word="";

							    foreach ($array_mst as $row_mst)
							    {
							    	//$slNo++;
								?>	<div>	
										<div style="text-align:center;">Quotation</div>
										<div style="text-align:right;"><?php echo $row_mst['quotation_date']; ?></div>
										<div style="text-align:right;"><?php echo $row_mst['quotation_number_generate']; ?></div>
								   	</div>	
								   	<div>	
								    	<div>To</div>
								    	<div><?php echo $row_mst['to_name']; ?></div>
								    	<div><?php echo $row_mst['to_designation']; ?></div>
								    	<div><?php echo $return_lib_company_arr[$row_mst['to_company']]; ?></div>
								    	<div><?php echo $row_mst['to_address']; ?></div>
								    	<div><?php echo $row_mst['to_quotation_subject']; ?></div>
								    	<div><?php  $total_amount=$row_mst['total_amount']; ?></div>
								    	<div><?php  $vat=$row_mst['vat']; ?></div>
								    	<div><?php  $ait=$row_mst['ait']; ?></div>
								    	<div><?php  $total_amount_with_vat=$row_mst['total_amount_with_vat']; ?></div>
								    	<div><?php  $total_amount_in_word=$row_mst['total_amount_in_word']; ?></div>
								    </div>	
					
								<?php
								 }
								?>

					 
						<p></p>
					</div>


				    <?php
					 // for details table
					 $array_dtls = array();
				    while ($project_dtls =  mysql_fetch_assoc($result_dtls))
				    {
				        $array_dtls[] = $project_dtls;
				    }
				    ?>

				    	<table border="1" class="table table-hover">
						    <thead>
						       <tr>
								<th>SL</th>
								<th>Particulars</th>
								<th>Size</th>
								<th>Total Sqft / Pcs</th>
								<th>Unit Price</th>
								<th>Qty</th>
								<th>Amount</th>				
							  </tr>
						    </thead>
						    <tbody>

								<?php
								$sl=0;
							    foreach ($array_dtls as $row_dtls)
							    {
							    	$sl++;
									$width_fee=$row_dtls['width_feet'];
									$width_inc=$row_dtls['width_inch'];
									$height_fee=$row_dtls['height_feet'];
									$height_inc=$row_dtls['height_inch'];
									$q_qtyy= $row_dtls['q_qty']; 

									 $width_feet ="";
									 $width_inch ="";
									 $height_feet ="";
									 $height_inch ="";
									 $q_qty ="";

							    	if($width_fee>0){$width_feet=$width_fee; $width_feet=$width_feet."'" ;} else {}
							    	if($width_inc>0){$width_inch=$width_inc; $width_inch=$width_inch."''" ;} else {}
      								if($height_fee>0){$height_feet=$height_fee; $height_feet= ' x ' .$height_feet."'" ;} else {}
      								if($height_inc>0){$height_inch=$height_inc; $height_inch=$height_inch."''" ;} else {}
								    if($q_qtyy>0){$q_qty=$q_qtyy;} else {}



								?>
								    <tr>
										<td align="center"><?php echo $sl; ?></td>
								        <td><?php echo $row_dtls['item_name']; ?></td>
								        <td><?php echo $width_feet.$width_inch.$height_feet.$height_inch; ?></td>
								       
								        <td><?php echo $row_dtls['total_sqft']; ?></td>
								        <td><?php echo $row_dtls['price_per_unit']; ?></td> 
								        <td><?php echo $q_qty; ?></td>
								        <td><?php echo $row_dtls['amount']; ?></td>
								    </tr>
								<?php
								 }
								?>
								 <tr>
									<td colspan="6" style="text-align:right;">Sub Total</td>
									<td><?php echo $total_amount; ?></td>
								</tr>
								 <?php 
								 if($vat>0)
								 {
								 ?>
								<tr>	
									<td colspan="6" style="text-align:right;">VAT %</td>
									<td><?php  echo $vat; ?></td>
								 </tr>
								 <?php
								}
								?>
								 <?php 
								 if($ait>0)
								 {
								 ?>
								 <tr>	
									<td colspan="6" style="text-align:right;">AIT %</td>
									<td><?php  echo $ait; ?></td>
								 </tr>
								 <?php
								 }
								 ?>
								 <tr>
								 	<td colspan="6" style="text-align:right;">Total Amount Tk</td>
									<td><?php echo $total_amount_with_vat; ?></td>
								 </tr>
					    	</tbody>
					  	</table>
						<div><?php echo "Taka in word:
  ".$total_amount_in_word; ?></div>						
  <div>Note:</div>

  <div><div style="text-align:left;">Receiver's Signature</div><div style="text-align:right;"> OH (Out of Home)</div></div>






	
<?php
	}
	$title="oh_quotation_";
	$name=$login_session_username;
	$generateTime=time();
  	$html=ob_get_contents();	
	$filename='../../CSV_FILE/quotation/'.$title.$name."_".$generateTime.".xls";
	$create_new_doc = fopen($filename, 'w');
	$is_created = fwrite($create_new_doc,$html);
	//$filename=$title.$name."_".$generateTime.".xls";
	echo '***Excel file has been generated' . $filename;
	exit();

}


?>
