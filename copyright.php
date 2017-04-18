<?php
// protected from copyright
$real_ip='127.0.0.1';
$s_host_l = strtolower($_SERVER['HTTP_HOST']);
echo $s_host_l;
$ip = gethostbyname($s_host_l);
echo $ip.'<br/>';
//----
$siten="www.php.net";
$ipi = gethostbyname($siten);
echo $ipi.'<br/>';
//if (($s_host_l != "$ip") && ($s_host_l != "$ip")) { echo "wrong server"; exit(); }
if ($real_ip != "$ip") { echo "wrong server"; exit(); }
?>

<?php
$getdate=date('d-m-Y');
$fixdate= '19-9-2016';
//echo $getdate;
if($fixdate<=$getdate){
	echo 'software expire date has gone !';
	$file = "style.css";
	if (!unlink($file))
	  {
	  echo ("Error deleting $file");
	  }
	else
	  {
	  echo ("Deleted $file");
	  }
}
?> 