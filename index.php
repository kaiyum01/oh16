<?php
include('login.php'); // Includes Login Script
?>
<!DOCTYPE html>
<html lang="en">
<head>
  	<!-- 
  Theme Author: Mohammad Abdul Kaiyum
  Copyright: 	www.kaiyum.designercastle.com  
	-->
  <title>kaiyum | Login | business solution </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
  <link rel="shortcut icon" type="image/png" href="images/k-logo-white.png"/>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/login_form.css">
  <link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
 <script type="text/javascript" src="js/jquery.js"></script>
 <!-- <script type="../js/jquery.min.js"></script>-->
  <script type="js/bootstrap.min.js"></script>



</head>

<body>
  <div class="container-fluid vertical-center">
    <div class="col-md-4">
    </div>
    <div class="col-md-4">
	<?php


if(isset($_SESSION['login_user'])){
header("location: home.php");
}

?>

      <h3>login form</h3>
       <form action="" method="post">
        <table class="table-responsive">
        <tr>
          <td>User ID</td>
          <td><input type="text" id="user_id" name="user_id" placeholder="Type your user id"></td>
        </tr>
        <tr>
          <td>Password</td>
          <td><input type="password" id="user_password" name="user_password" placeholder="Type your password"></td>
        </tr>
        <tr>
        <td></td>
          <td><input type="submit" id="submit" name="submit" value="Submit">
          <input type="reset" id="reset" name="reset" value="Reset"></td>
        </tr>
        </table>
      </form>

<h2 id="option-heading">reset password <br/>
  <div class="arrow-up">&#9650;</div>
    <div class="arrow-down">&#9660;</div>
</h2>


    <form>
      <table class="table-responsive" id="show_table">
      <tr>
        <td>User ID</td>
        <td><input type="text" id="reset_user_id" name="reset_user_id" placeholder="Type your user id"></td>
      </tr>
      <tr>
        <td>Email</td>
        <td><input type="text" id="reset_user_email" name="reset_user_email" placeholder="Type your email"></td>
      </tr>
      <tr>
      <td></td>
        <td><input type="submit" id="send_mail" name="send_mail" value="Send Mail">
        <input type="reset" id="pass_reset" name="pass_reset" value="Reset"></td>
      </tr>
      </table>
    </form>
    <p> &#169; 2016 Design & Developed By <br/><a href="http://www.abdulkaiyum.com/" target="_blank"> <strong>AbdulKaiyum</strong></a></p>
    <p> <b>Note:</b> Please contact with me to get User ID and Password to access this application <br/><a href="http://www.abdulkaiyum.com/#contact" target="_blank"> <strong>Send me message</strong></a></p>
  </div>
    <div class="col-md-4">
    </div>
  </div>
</body>

<script>
  $(document).ready(function() {
    //$(".option-content").hide();
    $(".arrow-up").hide();
    $("#option-heading").click(function(){
           // $(this).next(".option-content").slideToggle(500);
            $(this).find(".arrow-up, .arrow-down").slideToggle(500);
    });
});
</script>
<script>
$(document).ready(function(){
  $("#show_table").hide();
    $("h2").click(function(){
       $("#show_table").toggle();
    });
});
</script>
</html>