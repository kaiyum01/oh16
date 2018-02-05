<?php
// Establishing connection with server..
  $connection = mysql_connect("abdulkaiyum.com", "userName", "passWord");

// Selecting Database 
  $db = mysql_select_db("DBname", $connection);
  ?>
