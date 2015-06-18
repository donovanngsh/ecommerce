<?php
session_start();

if(!isset($_SESSION['CustomerID']))
{
	header("Location: login.php?status=notLogged");
}
?>

<!doctype html>
<html class="no-js" lang="en">
  <!-- include header -->
  <?php include('header.php'); ?>
  
  <body>
	  <!-- inlcude nav-menu-top -->
	  <?php include('./functions/navigation/nav-menu-top.php'); ?>
	  <!-- include container -->
	  <?php include('./main-registereduser.php'); ?>
	  <!-- include footer -->
	  <?php include('footer.php'); ?>
	  <!-- include script -->
	  <?php include('script.php'); ?>
  </body>
</html>
 