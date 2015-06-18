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
	<div class="row"> <h4><b>ITEM INFORMATION</b></h4> </div>

	<div class="row" id="ItemDetail">
		<div class="ItemDetailStore">	 
			<div class="ItemDetailStore-page">
				<ul class="small-block-grid-1 medium-block-grid-2 large-block-grid-2">
				<?php
				//Upload file Path Destination
				$setUploadedFilePath = "./UploadedFiles/";
				 
				$_GET;
				$ItemId = $_GET['ItemId']; 
				$ItemSaleQuery = $mysqli->query("SELECT T1.ItemID, T1.ItemName, T1.ItemSize, T1.ItemDescription, T1.ItemPrice, T1.ItemImageFileName,
				T1.ItemCondition, T1.ItemDelivery, T1.ItemSellingMode, T1.ItemSeller, T1.ItemBuyer, T1.ItemRemarks, T1.ItemNotify, T1.NogollasCategory, T1.RateItem, T1.NogollasPicks,
				T2.ItemStatusValue,
				T3.Rating, T3.Email As ItemSellerEmail, T3.UserName As ItemSellerUserName,
				T4.Email As ItemBuyerEmail, T4.UserName As ItemBuyerUserName
				FROM Item AS T1 
				INNER JOIN ItemStatuss AS T2 ON T1.ItemStatus = T2.ItemStatus
				Left Join Customer As T3 On T1.ItemSeller = T3.CustomerID
				Left Join Customer As T4 on T1.ItemBuyer = T4.CustomerID
				Where T1.ItemId = $ItemId
				ORDER BY T1.ItemID ASC");
  
				//count array row
				$ItemSaleQueryNumRows = mysqli_num_rows($ItemSaleQuery);
				
				If ($ItemSaleQueryNumRows > 0){	
				
				//Populate Items for Sale
					while($ItemSaleQueryObj = $ItemSaleQuery->fetch_object()) {
						
						echo '<li><div class="ItemImage"><img src="'.$setUploadedFilePath.$ItemSaleQueryObj->ItemImageFileName.'" /></div></li>';
						echo '<li>';
						echo '<form action="./func-processtransaction.php" method="POST">';
						echo '<div class="ItemName"><b>Item Status	: </b>'.$ItemSaleQueryObj->ItemStatusValue.'</div>';
						echo '<div class="ItemName"><b>Item Status	: </b>'.$ItemSaleQueryObj->ItemName.'</div>';
						echo '<p></p>';
						IF ($ItemSaleQueryObj->NogollasCategory == 'ITEM FOR REQUEST'){
						echo '<div class="ItemSize"><b>Remarks: </b>'.$ItemSaleQueryObj->ItemRemarks.' </div>';
						}
						Else{
						echo '<div class="ItemSize"><b>Size: </b>'.$ItemSaleQueryObj->ItemSize.' </div>';
						echo '<div class="ItemDescription"><b>Description			: </b>'.$ItemSaleQueryObj->ItemDescription.' </div>';
						echo '<div class="ItemPrice"><b>Price (SGD)			: </b> '.$ItemSaleQueryObj->ItemPrice.'</div>';
						echo '<div class="ItemCondition"><b>Item Condition		: </b> '.$ItemSaleQueryObj->ItemCondition.'</div>';
						echo '<div class="ItemDelivery"><b>Mode of Delivery	: </b> '.$ItemSaleQueryObj->ItemDelivery.'</div>';
						echo '<div class="ItemSellingMode"><b>Selling Mode		: </b> '.$ItemSaleQueryObj->ItemSellingMode.'</div>';
						echo '<div class="ItemSellerName"><b>Sellers Name 		: </b> '.$ItemSaleQueryObj->ItemSellerUserName.'</div>';
						echo '<div class="ItemSellerName"><b>Sellers Rating 		: </b> '.$ItemSaleQueryObj->Rating.'</div>';
						echo '<p></p>';
						}
						
						$session= $_SESSION['CustomerID'];
						$role = $_SESSION['Role'];
							
						if ($ItemSaleQueryObj->NogollasCategory == 'ITEM FOR SALE' ) {
							
							//Item - Available for SALE and Customer Enters
							If  (($role == 'CUSTOMER') AND (($ItemSaleQueryObj->ItemStatusValue == 'AVAILABLE') AND ($ItemSaleQueryObj->ItemSeller <> $session ))) {				
							echo '<a href="./func-reserveitemconfirmation.php?ItemId='.$ItemSaleQueryObj->ItemID.'" class="button" > Reserve Item</a>';
		
							echo '<h6> Make a Recommendation </h6>';
							echo '<div class="ReferAFriend"><label>Your Friend Email Address </label>';
							echo '<input type="email" name="email" placeholder="Enter your email">';

							echo '<button class="ReferAFriend expand" name="ReferAFriend[]" value = "'.$ItemSaleQueryObj->ItemID.'"> Tell A Friend</button>';
							echo '<p></p>';
							}
							//Item - Available for SALE and Administrator Enters
							If (($role == 'ADMIN') AND ($ItemSaleQueryObj->ItemStatusValue == 'AVAILABLE')){
								If ($ItemSaleQueryObj->NogollasPicks == 0) {
									echo '<button class="NogollasPicks expand" name="NogollasPicks[]" value = "'.$ItemSaleQueryObj->ItemID.'"> Nogollas Picks</button>';
								}
								Else {
									echo '<button class="RemoveNogollasPicks expand" name="RemoveNogollasPicks[]" value = "'.$ItemSaleQueryObj->ItemID.'"> Remove Nogollas Picks</button>';
								}
							}
		
							//For Session = Item Seller, Seller remove Posting for sale
							if ($ItemSaleQueryObj->ItemSeller == $session){
								
								If (($ItemSaleQueryObj->ItemStatusValue <> 'CLOSED DEAL') AND ($ItemSaleQueryObj->ItemStatusValue <> 'POST REMOVED')){
								echo '<button class="RemoveItemPost expand" name="RemoveItemPost[]" value = "'.$ItemSaleQueryObj->ItemID.'"> Remove Item Posting</button>';
								}
								If ($ItemSaleQueryObj->ItemStatusValue == 'RESERVED'){
								echo '<button class="MarkAsSold expand" name="MarkAsSold[]" value = "'.$ItemSaleQueryObj->ItemID.'"> Mark As Sold</button>';
								echo '<button class="ReleaseItem expand" name="ReleaseItem[]" value = "'.$ItemSaleQueryObj->ItemID.'"> Release Item For Sale</button>';
								}
							}
							
							//For Session = ItemBuyer, buyer cancel transaction
							if (($ItemSaleQueryObj->ItemBuyer == $session) AND ($ItemSaleQueryObj->ItemStatusValue <> 'CLOSED DEAL')){
							echo '<button class="CancelTrans expand" name="CancelTrans[]" value = "'.$ItemSaleQueryObj->ItemID.'"> Cancel Transaction</button>';
							}
							
							//For Closed Deals, Rate Seller
							if (($ItemSaleQueryObj->ItemBuyer == $session) AND (($ItemSaleQueryObj->ItemStatusValue == 'CLOSED DEAL' ) and ($ItemSaleQueryObj->RateItem == 0) )){	
							echo '<div class="Rating"><h6> Please rate the Seller on the following criteria </h6>';
							echo'<p></p>';
							echo '<label>Item </label>';
							echo '<h6>1<input type="range" name="sliderBar1" min="1" max="5" step="1" value="1";"/>5</h6>';
							echo '<label>Price </label>';
							echo '<h6>1<input type="range" name="sliderBar2" min="1" max="5" step="1" value="1";"/>5</h6>';
							echo '<label> Delivery </label>';
							echo '<h6>1<input type="range" name="sliderBar3" min="1" max="5" step="1" value="1";"/>5</h6>';
							echo '<label> Would you recommend this seller to others? </label>';
							echo '<h6>1<input type="range" name="sliderBar4" min="1" max="5" step="1" value="1";"/>5</h6></div>';
							echo '<button class="RateItemSeller expand" name="RateItemSeller[]" value = "'.$ItemSaleQueryObj->ItemID.'"> Submit Rating</button>';
							}
						}
						
						if ($ItemSaleQueryObj->NogollasCategory == 'ITEM FOR REQUEST' ) {
							
							//Item - Available for REQUEST and Customer Enters
							If  (($role == 'CUSTOMER') AND (($ItemSaleQueryObj->ItemStatusValue == 'AVAILABLE') AND ($ItemSaleQueryObj->ItemBuyer<> $session ))) {
								echo '<div class="ItemSeller"><b>Requestor UserName 		: </b> '.$ItemSaleQueryObj->ItemBuyerUserName.'</div>';
								echo '<div class="ItemSeller"><b>Requestor Email 		: </b> '.$ItemSaleQueryObj->ItemBuyerEmail.'</div>';
								echo '<button class="NotifyMe expand" name="NotifyMe[]" value = "'.$ItemSaleQueryObj->ItemID.'"> Notify Me</button>';
							}
							//Item - Not in Closed DEAL
							if (($ItemSaleQueryObj->ItemNotify == 1) AND ($ItemSaleQueryObj->ItemBuyer == $session) AND ($ItemSaleQueryObj->ItemStatusValue <> 'CLOSED DEAL')){
								echo '<button class="MarkAsSold expand" name="MarkAsSold[]" value = "'.$ItemSaleQueryObj->ItemID.'"> Mark As Sold</button>';
								
							}
							If (($ItemSaleQueryObj->ItemStatusValue <> 'CLOSED DEAL') AND ($ItemSaleQueryObj->ItemStatusValue <> 'POST REMOVED') AND ($ItemSaleQueryObj->ItemBuyer == $session)){
							echo '<button class="RemoveItemPost expand" name="RemoveItemPost[]" value = "'.$ItemSaleQueryObj->ItemID.'"> Remove Item Posting</button>';
							}
						}
						echo '</form>';
						echo '</li>';
					}
				}
				?>
				 
				</ul>
				<p></p>
			</div>	
		</div>	
	</div>		
		
	<?php
			//Close database
			$mysqli->close();
	?>

	<?php
	include('footer.php'); 
	include('script.php');
	?>
	</body>

</html>