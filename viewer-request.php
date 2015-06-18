 <?php include('header.php'); ?>
  
<?php 
//declare database connection
include('./functions/db_connect/db_connect.php'); 
//declare variables
global $mysqli;
?>
<body> 
	<!-- include nav-menu-top -->
	<?php include('./functions/navigation/nav-menu-top.php'); ?>
	
	<div class="row" id="ViewerRequest">
			<div class="ProductSale">
				<div class="panel viewstore-login">
					<h4>Please <a href="./login.php">Sign Up | Login</a> to continue</h4>
				</div>
				<div class="viewstore-page">
					<ul class="small-block-grid-2 medium-block-grid-4 large-block-grid-4">	
					<?php
					//Upload file Path Destination
					$setUploadedFilePath = "/nogollas-f3Latest/nogollas-f2/UploadedFiles/";
	
					//Display Item on Sale
					$ItemSaleQuery = $mysqli->query("SELECT ItemID, ItemName, ItemSize, ItemImageFileName 
					From Item Where NogollasCategory = 'ITEM FOR REQUEST' AND ItemStatus = 1 and ItemNotify = 0 ORDER BY ItemID DESC");
										
					//count array row
					$ItemSaleQueryNumRows = mysqli_num_rows($ItemSaleQuery);
							
					If ($ItemSaleQueryNumRows > 0){				
						//Populate Items for Sale
						while($ItemSaleQueryObj = $ItemSaleQuery->fetch_object()) {
						echo '<li class="Item th radius">';
						echo '<div class="ItemImage" align = "center"><img src="'.$setUploadedFilePath.$ItemSaleQueryObj->ItemImageFileName.'" /></div>';
						echo '<div class="ItemName" align = "center"><h6>'.$ItemSaleQueryObj->ItemName.' ( ' .$ItemSaleQueryObj->ItemSize.' ) </h6></div>';
						echo '</li>';
						}
					}
					else {
						echo '<h3>Items NOT Available. Please Check Back Again Later.</h3>';
					}
						//Release Memory
						$ProductSaleQuery=0; $ProductSaleQueryNumRows=0; $ProductSaleQueryObj=0;
					?>
					</ul>
				</div>
			</div>
	</div>
	
<?php
	//Close database
	$mysqli->close();
	include('footer.php'); 
	include('script.php');
?>
</body>

