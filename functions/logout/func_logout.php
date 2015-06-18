<?php 
//declare database connection
include('../db_connect/db_connect.php');
//declare variables
global $mysqli;

//set session
session_start();
if(!isset($_SESSION['CustomerID'])){
	header("Location: login.php?status=notLogged");
}
?>

<?php
	//declare variables
	global $mysqli;
	
	$session = $_SESSION['CustomerID'];
	echo $session;
	//Check if Customer is holding any projects yet have not check out to Paypal
	$ProductCheckCustomerQuery = $mysqli->query("SELECT ProductID From PRODUCT Where ProductStatus = '2' and ReserveBuyer = ".$_SESSION['CustomerID']."");
	//count array row
	$ProductCheckCustomerQueryNumRows = mysqli_num_rows($ProductCheckCustomerQuery);
								
		echo $ProductCheckCustomerQueryNumRows;
		If ($ProductCheckCustomerQueryNumRows > 0){
		//Release products that user is currently holding
			$ProductEmptyReserveBuyersStmt = $mysqli->prepare("UPDATE PRODUCT SET ProductStatus = '1', ReserveBuyer= '' where ProductStatus = '2' and ReserveBuyer = ".$_SESSION['CustomerID']."");
			$ProductEmptyReserveBuyersStmt->execute();
		}
	
	
	//Release Memory
	$ProductEmptyReserveBuyersStmt =0;
	session_destroy();
	echo 'User LogOut';
		
	//Close database
	$mysqli->close();
	//redirect
	header("Location: ../../login.php");
?>
