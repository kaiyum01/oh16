<?php
//function for 'mysql connect and database connect. booth are connected by this one function'
//CALL function as :  fnc_db_connection("localhost","root","","db_name");
function fnc_db_connection($host_name,$user_name,$password,$db_name)
{
	$sql_connect=mysql_connect($host_name,$user_name,$password);
	if($sql_connect!== false)
	{
		$select_db=mysql_select_db($db_name,$sql_connect);
		if($select_db==1)
		{
			//echo 'db name found'."<br/>";
		}
		else
		{
			echo 'YOUR DATABASE NOT FOUND !'."<br/>";
		}
		return;	
	}
	else 
	{
		echo 'FAILED TO CONNECT MYSQL !'."<br/>";
		return;
	}	
}
//function for 'pick up data from db table'
// >> this function return multi dimentional array of data set
// >> CALL function as : $var=fnc_pickup_data_from_db_table("id,name,age,address","info","id=1"); foreach(){tr,td,echo $var=['id']}
function fnc_pickup_data_from_db_table($field_name,$table_name,$where_con)
{
	if($where_con!="")
	{
		$sql="select $field_name from $table_name where $where_con";
	}
	else
	{
		$sql="select $field_name from $table_name";
	}
	//echo $sql;die;
	$mysql_qry=mysql_query($sql);
	$data=array();
	while($datas= mysql_fetch_array($mysql_qry))
	{
		//print_r($data);
		$data[]=$datas;
		//print_r($datas);
	}
	return $data;
}
//function for 'insert data to table'
//>> this function create insert query and execute query and send message.
//>> CALL functon as: fnc_insert_data("info","name,age,address","'$name','$age','$address'");	
function fnc_insert_data($table_name, $field_name,$values)
{
	$sql 		="insert into $table_name ($field_name) values ($values)";
	$mysql_qry 	=mysql_query($sql);
	if($mysql_qry==1)
	{
		echo 'inserted data';
	}
	else
	{
		echo 'Not inserted data';
	}
	return;	
}
//----------------------------------------------------------------------------------------
//echo $_SERVER['REQUEST_URI'];
$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
//echo $url."<br>";
$string = 'My nAmE is Tom.';
$array = array("name","tom");
if(0 < count(array_intersect(array_map('strtolower', explode(' ', $string)), $array)))
{
  //do sth
}
//print_r(str_word_count($url,1));
//-------------------------------------------------------------------------------------------

//chek duplicate data
function fnc_chk_duplicate_data($field_name,$table_name,$where_con,$chk_input_value)
{
	if($where_con!="")
	{
		$sql="select $field_name from $table_name where $where_con";
	}
	else
	{
		$sql="select $field_name from $table_name";
	}
	//echo $sql;die;
	$mysql_qry=mysql_query($sql);
	$data=array();
	while($datas= mysql_fetch_array($mysql_qry))
	{
		//print_r($data);
		$data[]=$datas;
		//print_r($datas);
	}
				$vall=array();
				foreach($data as $val)
				{
				 $vall[]=$val["$field_name"];
				} 
				print_r ($vall);
	if (in_array($chk_input_value,$vall)) 
	{
    	echo "Got duplicate";
		die;
	}
	else
	{
		echo 'not duplicate';
	}

}

//function for 'update data to table'
//>> this function create insert query and execute query and send message.
//>> CALL functon as: fnc_insert_data("info","name,age,address","'$name','$age','$address'");	
function fnc_update_data($table_name, $field_name,$values,$where_con)
{
	//UPDATE `info` SET `name` = 'jjjg', `age` = '10' WHERE `info`.`id` = 49;
	if($field_name !="")
	{
		$field_name=explode("*",$field_name);
		$values=explode("*",$values);
		$datas_arr="";
		for($i=0;$i<count($field_name);$i++)
		{
			if($datas_arr !="")
				$datas_arr.=",".$field_name[$i]."='".$values[$i]."'";
			else
				$datas_arr.=$field_name[$i]."='".$values[$i]."'";
		}
		
		$sql ="update $table_name set $datas_arr where $where_con";
	}
	//echo $sql;die;
	$mysql_qry 	=mysql_query($sql);
	if($mysql_qry==1)
	{
		return 1;
	}
	else
	{
		return 0;
	}
}


?>