<?php 
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

<!doctype html>
<html class="no-js" lang="en">
  <!-- include header.php -->
  <?php include('header.php'); ?>

 <body> 
 	<!-- include nav-menu-top -->
	<?php include('./functions/navigation/nav-menu-top.php'); ?>
	<p></p>
	<div class="row"> <h4><b>LOOKING FOR ITEMS</b></h4> </div>

	<div class="row" id="MainStore">
		<div class="MainStore-page">
			<ul class="small-block-grid-2 medium-block-grid-4 large-block-grid-4">
				
			<?php
			$session= $_SESSION['CustomerID'];
					
			//Upload file Path Destination
			$setUploadedFilePath = "/nogollas-f3Latest/nogollas-f2/UploadedFiles/";
 
			//Retrieve all Requested Items
			$ItemSaleQuery = $mysqli->query("SELECT ItemID, ItemName, ItemSize, ItemImageFileName 
			From Item Where NogollasCategory = 'ITEM FOR REQUEST' AND ItemStatus = 1 and ItemNotify = 0 AND ItemBuyer <> '$session' ORDER BY ItemID DESC");
								
			//count array row
			$ItemSaleQueryNumRows = mysqli_num_rows($ItemSaleQuery);
				
			If ($ItemSaleQueryNumRows > 0){	
				
				//Populate Items for Sale
				while($ItemSaleQueryObj = $ItemSaleQuery->fetch_object()) {
					echo '<li class="Item th radius">';
					echo '<div class="ItemImage"><img src="'.$setUploadedFilePath.$ItemSaleQueryObj->ItemImageFileName.'" /></div>';
					echo '<div class="ItemName" align = "center"><h6><a href="./main-displaytransdetail.php?ItemId='.$ItemSaleQueryObj->ItemID.'">'.$ItemSaleQueryObj->ItemName.' ( ' .$ItemSaleQueryObj->ItemSize.' ) </h6></a></div>';
					echo '</li>';
				}
			}
			else {
					echo '<div class="store-Instruct">';
					echo '<h4>There is no request for item. Please check back later.</h4>';
					echo '</div>';
			}
			//Release Memory
			$ItemSaleQuery=0; $ItemSaleQueryNumRows=0; $ItemSaleQueryObj=0;
			?>
			</ul>
			<p></p>
		</div>	
	</div>		
		
	<?php
	$mysqli->close();
	include('footer.php'); 
	include('script.php');
	?>
	</body>
</html>