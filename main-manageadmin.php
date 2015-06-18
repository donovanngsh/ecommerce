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
$role = $_SESSION['Role'];
If  ($role <> 'ADMIN'){
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
	<div class="row"> <h4> Administrator View </h4></div>

	<div class="row" id="MainStore">
		<div class="AllStore">
			<div class="MainStore-page">
				<ul class="small-block-grid-2 medium-block-grid-4 large-block-grid-4">
				<?php
					$session= $_SESSION['CustomerID'];
					 
					//Upload file Path Destination
					$setUploadedFilePath = "/nogollas-f3Latest/nogollas-f2/UploadedFiles/";
					$ItemSaleQuery = $mysqli->query("SELECT ItemID, ItemName, ItemSize, ItemPrice, ItemImageFileName 
					From Item Where NOGOLLASCATEGORY='ITEM FOR SALE' And ItemStatus = 1 ORDER BY ItemID DESC");
								
					//count array row
					$ItemSaleQueryNumRows = mysqli_num_rows($ItemSaleQuery);
				
					If ($ItemSaleQueryNumRows > 0){	
				
						//Populate Items for Sale
						while($ItemSaleQueryObj = $ItemSaleQuery->fetch_object()) {
							echo '<li class="Item th radius">';		
							echo '<div class="ItemImage"><img src="'.$setUploadedFilePath.$ItemSaleQueryObj->ItemImageFileName.'" /></div>';
							echo '<div class="ItemName" align = "center"><h6><a href="./main-displaytransdetail.php?ItemId='.$ItemSaleQueryObj->ItemID.'">'.$ItemSaleQueryObj->ItemName.' ( ' .$ItemSaleQueryObj->ItemSize.' ) </h6></a></div>';
							echo '<div class="ItemPrice" align = "center"><h6>SGD '.$ItemSaleQueryObj->ItemPrice.'</h6></div>' ;
							echo '</li>';
						}
					}
					else {
							echo '<div class="store-text">';
							echo '<h4>Item Not Available. Please Check Back Later.</h4>';
							echo '</div>';
						}
					//Release Memory
					$ItemSaleQuery=0; $ItemSaleQueryNumRows=0; $ItemSaleQueryObj=0;
				?>
				</ul>
				<p></p>
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
</html>