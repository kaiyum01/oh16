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
include('../../include/common_function.php');
include('../../include/array_function.php');
include('../../include/message_function.php');

//action=save_data,Fetching Values from URL
if(	isset($_POST['action']) &&
 	isset($_POST['company_code1']) && 
 	isset($_POST['contact_person_name1']) && 
 	isset($_POST['division1'])&&
	isset($_POST['address1']) &&
	isset($_POST['company_name1'])&&
	isset($_POST['person_phone1']) && 
 	isset($_POST['area1']) && 
 	isset($_POST['email1'])&&
	isset($_POST['company_phone1']) &&	
	isset($_POST['short_name1']) && 
 	isset($_POST['person_desig1']) && 
 	isset($_POST['tin1'])&&
	isset($_POST['website1'])&& 
	isset($_POST['faxno1']) 
 	//isset($_POST['contact1'])
 	){
	$action_save			=$_POST['action'];
	$company_code2			=$_POST['company_code1'];
	$contact_person_name2	=$_POST['contact_person_name1'];
	$division2				=$_POST['division1'];
	$address2				=$_POST['address1'];
	$company_name2			=$_POST['company_name1'];
	$person_phone2			=$_POST['person_phone1'];
	$area2					=$_POST['area1'];
	$email2					=$_POST['email1'];
	$company_phone2			=$_POST['company_phone1'];
	$short_name2			=$_POST['short_name1'];
	$person_desig2			=$_POST['person_desig1'];
	$tin2					=$_POST['tin1'];
	$website2				=$_POST['website1'];
	$faxno2					=$_POST['faxno1'];
	if($action_save=="save_data")
	{
	//company_code,contact_person_name,division,address,company_name,person_phone,area,email,company_phone,short_name,person_desig,tin,website,faxno
	//company_code2,contact_person_name2,division2,address2,company_name2,person_phone2,area2,email2,company_phone2,short_name2,person_desig2,tin2,website2,faxno2
	  	$query = mysql_query("insert into lib_client_entry(company_code,contact_person_name,division,address,company_name,person_phone,area,email,company_phone,short_name,person_desig,tin,website,faxno,insert_date,inserted_by) values ('$company_code2','$contact_person_name2','$division2','$address2','$company_name2','$person_phone2','$area2','$email2','$company_phone2','$short_name2','$person_desig2','$tin2','$website2','$faxno2','$insert_and_update_date','$login_session_user_id')");
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

// show list view action start here
if(isset($_GET['action'])){
	 $action_view_data= $_GET['action'];
	// echo $actions;
	if($action_view_data=="list_view")
	{
		$i=0;
		$result=mysql_query("select * from lib_client_entry where is_deleted=0 and status_active=1 order by id DESC");
		?>
		<table class="table table-hover">
		<thead>
		  <tr>
			<th>sl</th>
			<th>company name</th>
			<th>contact person name</th>
			<th>person phone</th>
			<th>area</th>			
			<th>email</th>
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
        <td><?php echo $data[5]; ?></td>
        <td><?php echo $data[2]; ?></td>
        <td><?php echo $data[6]; ?></td>
		<td><?php echo $data[7]; ?></td>
		<td><?php echo $data[8]; ?></td>
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
		$sql= mysql_query("select * from lib_client_entry where id=$idd");
		while($result = mysql_fetch_assoc($sql)) {
			echo json_encode($result);
		}
		 
	 }
}
//Update data
//Fetching Values from URL
if(	isset($_POST['action']) &&
 	isset($_POST['company_code1']) && 
 	isset($_POST['contact_person_name1']) && 
 	isset($_POST['division1'])&&
	isset($_POST['address1']) &&
	isset($_POST['company_name1'])&&
	isset($_POST['person_phone1']) && 
 	isset($_POST['area1']) && 
 	isset($_POST['email1'])&&
	isset($_POST['company_phone1']) &&	
	isset($_POST['short_name1']) && 
 	isset($_POST['person_desig1']) && 
 	isset($_POST['tin1'])&&
	isset($_POST['website1'])&& 
	isset($_POST['faxno1']) &&
	isset($_POST['update_id1'])   
 	//isset($_POST['contact1'])
 	){
	$action_update			=$_POST['action'];
	$company_code2			=$_POST['company_code1'];
	$contact_person_name2	=$_POST['contact_person_name1'];
	$division2				=$_POST['division1'];
	$address2				=$_POST['address1'];
	$company_name2			=$_POST['company_name1'];
	$person_phone2			=$_POST['person_phone1'];
	$area2					=$_POST['area1'];
	$email2					=$_POST['email1'];
	$company_phone2			=$_POST['company_phone1'];
	$short_name2			=$_POST['short_name1'];
	$person_desig2			=$_POST['person_desig1'];
	$tin2					=$_POST['tin1'];
	$website2				=$_POST['website1'];
	$faxno2					=$_POST['faxno1']; 
	$update_id2				=$_POST['update_id1'];
	
	if($action_update=="update_data")
	{
	//update query 
	
	  $query_update = mysql_query("update lib_client_entry SET company_code='$company_code2',contact_person_name='$contact_person_name2',division='$division2',address='$address2',company_name='$company_name2',person_phone='$person_phone2',area='$area2',email='$email2',company_phone='$company_phone2',short_name='$short_name2',person_desig='$person_desig2',tin='$tin2',website='$website2',faxno='$faxno2',update_date='$insert_and_update_date',updated_by='$login_session_user_id' where id='$update_id2'");
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
//-------------------
	// Delete action
if(isset($_POST['action'])){
	 $action_delete= $_POST['action'];//$_POST['action'];
	 if($action_delete=="delete_data_action")
	 {
		$delete_id=$_POST['delete_id'];
		$sql_delete= mysql_query("update lib_client_entry SET status_active=0, is_deleted=1,update_date='$insert_and_update_date',updated_by='$login_session_user_id' where id='$delete_id'");
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
		$result=mysql_query("select * from lib_client_entry where company_name='$search_value2' and is_deleted=0 and status_active=1 order by id DESC");
		?>
		<table class="table table-hover">
    <thead>
      <tr>
      	<th>sl</th>
        <th>user name</th>
        <th>user type</th>
        <th>Email</th>
		<th>status</th>
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
        <td><?php echo $data[5]; ?></td>
        <td><?php echo $data[2]; ?></td>
        <td><?php echo $data[6]; ?></td>
		<td><?php echo $data[7]; ?></td>
		<td><?php echo $data[8]; ?></td>
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