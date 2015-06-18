<?php

//declare database connection
include('./functions/db_connect/db_connect.php');

//declare variables
global $mysqli;
session_start();

?>

<!doctype html>
<html class="no-js" lang="en">
  <!-- include header -->
  <?php include('header.php'); ?>
  
  <body>
	  <!-- include nav-menu-top -->
	  <?php include('./functions/navigation/nav-menu-top.php'); ?>
	  <!-- include container -->
	  <?php include('./main-index.php'); ?>
	  <!-- include footer -->
	  <?php include('footer.php'); ?>
	  <!-- include script -->
	  <?php include('script.php'); ?>
  </body>
</html> 
 