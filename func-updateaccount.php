<?php 
session_start();
//declare database connection 
include('./functions/db_connect/db_connect.php');
//declare variables
global $mysqli;
//set session
session_start();
if(!isset($_SESSION['CustomerID'])){
	header("Location: login.php?status=notLogged");
}
?>

<?php
	$password = $_POST['password'];
	$birthday = $_POST['birthday'];
	$gender =	$_POST['gender'];
	
	if (($_POST['password'] == NULL) AND ($_POST['birthday']== NULL) AND ($_POST['gender']== NULL)){
		header("Location: main-managetrans.php?msg=15");
		exit();
	}
	Else{
	
		if ($_POST['password'] == NULL){
		}
		Else {
			$CustomerUpdateInfoStmt = $mysqli->prepare("UPDATE Customer SET password = '$password' Where CustomerID = ".$_SESSION['CustomerID']."");			
			$CustomerUpdateInfoStmt->execute();
		}
		
		if ($_POST['birthday']== NULL) {
		}
		ELSE {
			$CustomerUpdateInfoStmt = $mysqli->prepare("UPDATE Customer SET birthday = '$birthday' Where CustomerID = ".$_SESSION['CustomerID']."");			
			$CustomerUpdateInfoStmt->execute();
		}
		
		if ($_POST['gender']== NULL){
		}
		Else{
			$CustomerUpdateInfoStmt = $mysqli->prepare("UPDATE Customer SET gender = '$gender' Where CustomerID = ".$_SESSION['CustomerID']."");			
			$CustomerUpdateInfoStmt->execute();
		}
		
		header("Location: main-managetrans.php?msg=11");
		exit();
	}
	
	//Close database
	$mysqli->close();
?>
