<?php
//connect to db
include ('../db_connect/db_connect.php');
//declare variables
global $mysqli;

try {
	FuncCheckCustomer(); 
}
catch(Exception $error) {
	echo '<h4>'.$error->getMessage().'</h4>';
}

function FuncCheckCustomer() {
	//declare variables 
	global $mysqli;
	$getUser 		= $mysqli->real_escape_string($_POST['user']);
	$getPassword 	= $mysqli->real_escape_string($_POST['password']);
	
	$checkUserNameExistQuery = $mysqli->query("SELECT UserName FROM Customer WHERE UserName = '$getUser' AND Password = '$getPassword'");
	
	$checkUserNameExistQueryNumRow = mysqli_num_rows($checkUserNameExistQuery);
	if ($checkUserNameExistQueryNumRow >= 1)
	{
		FuncCreateSession();
	}
	else {
		header("Location: ../../login.php?error=noMatch");
		exit();
	}
}

function FuncCreateSession() {
	//declare variables
	global $mysqli;
	$getUser = $mysqli->real_escape_string($_POST['user']);
	
	//session start
	session_start();
	
	//store a session
	$getCustomerIDQuery =  $mysqli->query("SELECT CustomerID, ROLE FROM Customer WHERE Username = '$getUser'");
	while ($row = $getCustomerIDQuery->fetch_assoc())
	{
		$_SESSION['CustomerID'] = $row['CustomerID'];
		$_SESSION['Role'] = $row['ROLE'];
	}
	header("Location: ../../main-managetrans.php");
}
	
/* explicit close */
$mysqli->close();
?>