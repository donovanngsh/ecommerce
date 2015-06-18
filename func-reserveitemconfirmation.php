<!doctype html>
<html class="no-js" lang="en">
  <!-- include header.php -->
  <?php include('header.php'); ?>
  
<?php 
//session_start(); 
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

 <body> 
 	<!-- include nav-menu-top -->
	<?php include('./functions/navigation/nav-menu-top.php'); ?>
	<p></p>
	<div class="row"> <h4>Reservation Confirmation</h4></div>

	<div class="row" id="MainStore">
			<div class="MainStore-page">
			<div class="row" align = "center"> <h4>You have selected to RESERVE the following Item:</h4>
			
			<?php			
				If  ($role == 'CUSTOMER'){
					//For Customer Role Process
					//Upload file Path Destination
					$setUploadedFilePath = "/nogollas-f3Latest/nogollas-f2/UploadedFiles/";
					$_GET; 
					$ItemId = $_GET['ItemId']; 
						
					$ItemSaleQuery = $mysqli->query("SELECT T1.ItemID, T1.ItemName, T1.ItemSize, T1.ItemPrice, T1.ItemImageFileName, T1.ItemInstructionForBuyer, T2.Email 
					FROM Item AS T1 INNER JOIN Customer AS T2 ON T1.ItemSeller = T2.CustomerID Where T1.ItemID = '$ItemId' ORDER BY T1.ItemID ASC");
					
					//count array row
					$ItemSaleQueryNumRows = mysqli_num_rows($ItemSaleQuery);
							
					If ($ItemSaleQueryNumRows > 0){	
						//Populate Items for Sale
						while($ItemSaleQueryObj = $ItemSaleQuery->fetch_object()) {
							echo '<form action="./func-reserveitem.php" method="POST">';
							echo '<div class="ItemImage" align = "center"><img src="'.$setUploadedFilePath.$ItemSaleQueryObj->ItemImageFileName.'" /></div>';
							echo '<div class="ItemName" align = "center"><h6><a href="./main-displaytransdetail.php?ItemId='.$ItemSaleQueryObj->ItemID.'">'.$ItemSaleQueryObj->ItemName.' ( ' .$ItemSaleQueryObj->ItemSize.' ) </h6></a></div>';
							echo '<div class="ItemPrice" align = "center"><h6>SGD '.$ItemSaleQueryObj->ItemPrice.'</h6></div>' ;
							echo '<div class="ItemInstructionForBuyer" align = "center"><h6><b> Instruction For Buyer: </b>'.$ItemSaleQueryObj->ItemInstructionForBuyer.'</h6></div>' ;
							echo '<div class="CustomerEmail" align = "center"><h6><b> Seller Email Address: </b>'.$ItemSaleQueryObj->Email.'</h6></div>' ;
							
							echo '<p></p>';
							echo '<h5>Your Name and Email will be emailed to the seller. You are strongly encouraged to contact him/her 
									as soon as possible. The Seller information will be available to you upon confirmation of reserving 
									this item. The reservation will only hold for 6 hours and seller reserved the rights to release the 
									reservation before the withholdment timeframe.</h5> </div>';
						
							echo '<p></p>';
							echo '<button class="ReserveItem expand" name="ReserveItem[]" value = "'.$ItemSaleQueryObj->ItemID.'"> Confirm to Proceed </button>';
							echo '</form>';
						}
					}
				}				
			?>		
			</div>	
	</div>		
	
	<?php
	//Close database
	$mysqli->close();
	include('footer.php'); 
	include('script.php');
	?>
	</body>
</html>