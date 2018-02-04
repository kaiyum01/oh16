<?php
$insert_and_update_date=date('Y-m-d H:i:s');
$only_today_date=date('Y-m-d');
function return_next_id( $field_name, $table_name, $max_row=1 )        // Checked   3
{
  // This function will Return Last number of Row of table 
  // To generate next Id 
  // Return value:  number
  // Uses  single field:: return_next_id("id", "lib_buyer", "1");
  //$nameArray=array();

  $increment=1;
  $queryText="select max(".$field_name.") as ".$field_name."  from ".$table_name." "  ;
  //$nameArray=sql_select( $queryText,'', $new_conn );
  $nameArray=mysql_query($queryText);
  while($data = mysql_fetch_array($nameArray))
  {   
   return ($data[0]+$increment);
  }
    //return ($result[$field_name]+$increment); 
  
}

function change_date_format($date, $new_format, $new_sep, $on_save )
{
	//This function will return newly formatted date String
	// uses  --> echo change_date_format($date,"dd-mm-yyyy","/")
	global $db_type;
	
	if ($new_sep=="") $new_sep="-";
	if ($new_format=="") $new_format="dd-mm-yyyy";
	if ($date=="" || $date=="0000-00-00") $date="0000-00-00";
	
	if ( $db_type==2 )
	{
		if ($date=="0000-00-00") return "";
		if( $on_save==0 )
		{
			if ($new_format=="yyyy-mm-dd")
				return date("Y-m-d",strtotime($date));
			else
				return date("d-m-Y",strtotime($date));
		}
			
		else
			return date("d-M-Y",strtotime($date));
	}
	
	$year=date("Y",strtotime($date));
	$mon=date("m",strtotime($date));
	$day=date("d",strtotime($date));
	
	if ($new_format=="yyyy-mm-dd")  // yyyy-mm-dd
		$dd= $year.$new_sep.$mon.$new_sep.$day ;
	else if ($new_format=="dd-mm-yyyy")  // dd-mm-yyyy
		$dd= $day.$new_sep.$mon.$new_sep.$year ;
	if ($db_type==0 || $db_type==1)
		if ($dd=="1970-01-01" || $dd=="01-01-1970") return ""; else return $dd;
	else
		if ($dd=="1970-01-01" || $dd=="01-01-1970") return ""; else return date("Y-M-d",strtotime($dd));
	//die;
}

function get_extra_code($emp_code)
{
	return sprintf("%07d", $emp_code);
}

function number_to_words( $number, $full_unit, $half_unit )
{
	// This function returns amount in word
	// uses :: echo number_to_words("55555555250", "USD", "CENTS");
	//$number=number_format($number,2);
    if (($number < 0) || ($number > 99999999999))
    {
       throw new Exception("Number is out of range");
    }
	$number=explode('.',$number);
	if($number[1]=="" || $number==0)
	{
		$result1= " ".$full_unit; 
		$number=$number[0];
	}
	else 
	{
		$result1= " ".$full_unit." and ". number_to_words($number[1]) . " ".$half_unit; 
		$number=$number[0];
	}
	
	$Cn = floor($number / 10000000);  /* Crore (giga) */
    $number -= $Cn * 10000000;
	
   // $Gn = floor($number / 1000000);  /* Millions (giga) */
    //$number -= $Gn * 1000000;
	
	$Ln = floor($number / 100000);  /* Lacs (giga) */
    $number -= $Ln * 100000;
	
    $kn = floor($number / 1000);     /* Thousands (kilo) */
    $number -= $kn * 1000;
    $Hn = floor($number / 100);      /* Hundreds (hecto) */
    $number -= $Hn * 100;
    $Dn = floor($number / 10);       /* Tens (deca) */
    $n = $number % 10;               /* Ones */ 
     
	$result = ""; 
	 if ($Cn)
    {  $result .= number_to_words($Cn) . " Crore ";  } 
	
   /* if ($Gn)
    {  $result .= number_to_words($Gn) . " Million ";  } 
	*/
	if ($Ln)
    {  $result .= number_to_words($Ln) . " Lacs ";  } 

    if ($kn)
    {  $result .= (empty($result) ? "" : " ") . number_to_words($kn) . " Thousand "; } 

    if ($Hn)
    {  $result .= (empty($result) ? "" : " ") . number_to_words($Hn) . " Hundred ";  } 

    $ones = array("", "One", "Two", "Three", "Four", "Five", "Six",
        "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen",
        "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen",
        "Nineteen");
    $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty",
        "Seventy", "Eighty", "Ninety"); 

    if ($Dn || $n)
    {
       if (!empty($result))
       {  $result .= " and ";
       } 

       if ($Dn < 2)
       {  $result .= $ones[$Dn * 10 + $n];
       }
       else
       {  $result .= $tens[$Dn];
          if ($n)
          {  $result .= "-" . $ones[$n];
          }
       }
    }
	
    if (empty($result))
    {  $result = "Zero"; } 
	
    return "$result "." $result1";
}

?>