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
	exit();
}
?>

<?php
	//Customer Role
	If($_POST['ReserveItem']==NULL){	
		echo 'Items not selected on this submission. Please try again. ';
	}
	Else{
		$session= $_SESSION['CustomerID'];
		$time = time();
		date_default_timezone_set('Asia/Singapore');
		$date = date('m/d/Y h:i:s a',time());
	
		foreach($_POST['ReserveItem'] as $ReserveItemValue){		
			$ItemReserveItemStmt1 = $mysqli->prepare("INSERT INTO ItemEmail( DateCreated, ItemID, SendEmail )
													VALUES ('$date', '$ReserveItemValue', 1)");
			$ItemReserveItemStmt2 = $mysqli->prepare("UPDATE ITEM SET ItemBuyer = '$session', ItemStatus = 2, LastUpdateBy ='$session', DateUpdated='$date'  WHERE ItemId = '$ReserveItemValue'");
			$ItemReserveItemStmt1->execute();
			$ItemReserveItemStmt2->execute();				
			include('func-sendemail.php');
			header("Location: main-managetrans.php?msg=3");
			exit();
		}
	}
	
	//Close database
	$mysqli->close();	
?>
