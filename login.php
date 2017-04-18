<?php
include('include/db_connection.php');
//// Establishing connection with server..
//  $connection = mysql_connect("localhost", "root", "");
//// Selecting Database 
//  $db = mysql_select_db("oh16", $connection);
session_start(); // Starting Session
$error=''; // Variable To Store Error Message
if (isset($_POST['submit'])) 
{
	if (empty($_POST['user_id']) || empty($_POST['user_password'])) 
	{
		$error = "Username or Password is invalid";
		echo '<p style="color:#EE5269;">'.$error.'</p>';
	}
	else
	{
		// Define $username and $password
		$username=$_POST['user_id'];
		$password=$_POST['user_password'];
		
		// To protect MySQL injection for Security purpose
		$username = stripslashes($username);
		$password = stripslashes($password);
		$username = mysql_real_escape_string($username);
		$password = mysql_real_escape_string($password);
		// SQL query to fetch information of registerd users and finds user match.
		$query = mysql_query("select user_name,pass_word from admin_user_create where pass_word='$password' AND user_name='$username' and is_deleted=0 and status_active=1");
		$rows = mysql_num_rows($query);
		if ($rows == 1) 
		{
			$_SESSION['login_user']=$username; // Initializing Session
			header("location: home.php"); // Redirecting To Other Page
		} 
		else 
		{
			$error = "Username or Password is invalid";
			echo '<p style="color:#EE5269;">'.$error.'</p>';
		}
		mysql_close($connection); // Closing Connection
	}
}
?>