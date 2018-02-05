<?php
// Establishing connection with server..
  $connection = mysql_connect("localhost", "userName", "passWord");

// Selecting Database 
  $db = mysql_select_db("DBname", $connection);
  ?>
