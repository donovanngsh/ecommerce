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
  <!-- include header -->
  <?php include('header.php'); ?>
  
  


 <body> 
  <!-- include navigation-top -->
	  <?php include('./functions/navigation/nav-menu-top.php'); ?>
	  
	<p></p>
	<div class="row">
		<ul class="small-block-grid-2 medium-block-grid-4 large-block-grid-4">
			<li align ="left"> <h4><b>MEN STYLE </b></h4></li>	
			<li></li>
			<li></li> 
			<li align ="right">
				<?php
				echo '<select name="Category" onChange="getSubCategory(this.value)">';
				$CategoryQuery = $mysqli->query("SELECT CategoryID, SubCategory FROM Categorys Where Category = 'MEN' OR CategoryID = 0");
				$CategoryQueryNumRows = mysqli_num_rows($CategoryQuery);
				while($CategoryQueryObj = $CategoryQuery->fetch_object()) {
					echo '<option value="'.$CategoryQueryObj->CategoryID.'">'.$CategoryQueryObj->SubCategory.'</option>';
				}
				echo "</select>";
				?>
			</li>	
		</ul>
	</div>
				
	
	<div class="row" id="MainStore">
		<div class="MenStore">
			<div class="MainStore-page">
				<ul class="small-block-grid-2 medium-block-grid-4 large-block-grid-4">
				<?php
				
				//Upload file Path Destination
				$setUploadedFilePath = "./UploadedFiles/";
				global $mysqli;
				$_GET; 
				$CategoryID = $_GET['CategoryID'];
				$session =$_SESSION['CustomerID'];
								
				If ($CategoryID == NULL) {	
					$ItemListQuery = $mysqli->query(" 
					SELECT T1.ItemID, T1.ItemName, T1.ItemSize, T1.ItemPrice, T1.ItemImageFileName , T2.Category
					FROM Item AS T1 INNER JOIN Categorys AS T2 ON T1.ItemCategory = T2.CategoryID
					Where T1.NOGOLLASCATEGORY='ITEM FOR SALE' And T1.ItemStatus = 1 AND T1.ItemSeller <> '$session' AND T2.Category = 'MEN' ORDER BY ItemID DESC");	
				}
				Else {
					$ItemListQuery = $mysqli->query("SELECT ItemID, ItemName, ItemSize, ItemPrice, ItemImageFileName 
					From Item Where ItemCategory = '$CategoryID' AND NOGOLLASCATEGORY='ITEM FOR SALE' And ItemStatus = 1 AND ItemSeller <> '$session' ORDER BY ItemID DESC");			
				}
			
				//count array row
				$ItemListQueryNumRows = mysqli_num_rows($ItemListQuery);
				
					If ($ItemListQueryNumRows > 0){	
				
						//Populate Items for Sale
						while($ItemListQueryObj = $ItemListQuery->fetch_object()) {
							echo '<li class="Item th radius">';		
							echo '<div class="ItemImage"><img src="'.$setUploadedFilePath.$ItemListQueryObj->ItemImageFileName.'" /></div>';
							echo '<div class="ItemName" align = "center"><h6><a href="./main-displaytransdetail.php?ItemId='.$ItemListQueryObj->ItemID.'">'.$ItemListQueryObj->ItemName.' ( ' .$ItemListQueryObj->ItemSize.' ) </h6></a></div>';
							echo '<div class="ItemPrice" align = "center"><h6>SGD '.$ItemListQueryObj->ItemPrice.'</h6></div>' ;
							echo '</li>';
						}
					}
					else {
							echo '<div class="store-text">';
							echo '<h4>Item Not Available For Purchase. Please Check Back Later.</h4>';
							echo '</div>';
						}
				//Release Memory
				$ItemListQuery=0; $ItemListQueryNumRows=0; $ItemListQueryObj=0;
				?>

				</ul>
			<p></p>	
			</div>	
		</div>	
	</div>				
	</body>
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript"> 
		function getSubCategory($CategoryID){  
			$.ajax({		
					type: "POST",
					success: function(){
					window.location = "main-menstore.php?CategoryID="+$CategoryID
					}
			}); 
		}
	</script>
	
	  <!-- include footer -->
	  <?php $mysqli->close(); ?>
	  <?php include('footer.php'); ?>
	  <!-- include script -->
	  <?php include('script.php'); ?>	  
</html>