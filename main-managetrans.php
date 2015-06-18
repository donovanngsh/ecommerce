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
  <?php 
  include('header.php'); 
  ?>  

 <body> 
 	<!-- include nav-menu-top -->
	<?php include('./functions/navigation/nav-menu-top.php'); ?>
	<p></p>
	<div class="row"> <h4><b>MANAGE TRANSACTIONS</b></h4> </div>
		
	<div class="row" id="MainStore">
		<div class="MainStore-page">
		<!-- Message/Error Handling -->  
		<?php $msg = $_GET['msg'];
			
		if ($msg == null){
		}
		Else{
			global $mysqli;
			$MessageQuery = $mysqli->query("SELECT ErrorID, ErrorType, ErrorMessage, ErrorMessageValue From ErrorMessage Where ErrorID = '$msg'");
			$MessageQueryNumRows = mysqli_num_rows($MessageQuery);
			If ($MessageQueryNumRows > 0){
				 
				while($MessageQueryObj = $MessageQuery->fetch_object()) {
					if ($MessageQueryObj->ErrorType == 'FAIL') {
						echo "<div class=\"failValidate\">";
					}
					Else{
						echo "<div class=\"passValidate\">";
					}
					echo '<p>'.$MessageQueryObj->ErrorMessageValue.'</p>';
					echo "</div>";
				}
			}
		}	
		?>
			
		<table> 
			<thead>
				<tr>
				<th width="50" style="border: 1px solid black;">Item ID</th>
				<th width="100" style="border: 1px solid black;">Item Status</th>
				<th width="500" style="border: 1px solid black;">Item Name</th>
				<th width="120" style="border: 1px solid black;">Total (SGD $)</th>
				<th width="200" style="border: 1px solid black;">Transaction Type</th>
				</tr>
			</thead>
			<tbody>
				
			<?php
			$session= $_SESSION['CustomerID'];
			global $mysqli;
			
			//Upload file Path Destination
			$setUploadedFilePath = "./nogollas/nogollas-f3/UploadedFiles/";
	
			//Retrieve all Requested Items
			$ItemSaleQuery = $mysqli->query("
			SELECT T1.ItemID, T1.ItemName, T1.NogollasCategory, T1.ItemStatus, T1.ItemPrice, T2.ItemStatusValue
			FROM Item AS T1 INNER JOIN ItemStatuss AS T2 ON T1.ItemStatus = T2.ItemStatus
			Where T1.ItemSeller = '$session' or T1.ItemBuyer = '$session'
			ORDER BY ItemID ASC;
			");
					
			//count array row
			$ItemSaleQueryNumRows = mysqli_num_rows($ItemSaleQuery);
					
			If ($ItemSaleQueryNumRows > 0){				 
				//Populate Items for Sale
				while($ItemSaleQueryObj = $ItemSaleQuery->fetch_object()) {	
					echo '<tr >';
					echo '<td style="border: 1px solid black;"><div class="ItemID"><h6><a href="./main-displaytransdetail.php?ItemId='.$ItemSaleQueryObj->ItemID.'">'.$ItemSaleQueryObj->ItemID.'</h6></a></div></td>';
					echo '<td style="border: 1px solid black;"><div class="ItemStatus"><h6>'.$ItemSaleQueryObj->ItemStatusValue.'</h6></div></td>';
					echo '<td style="border: 1px solid black;"><div class="ItemName"><h6>'.$ItemSaleQueryObj->ItemName.'</h6></div></td>';
					echo '<td style="border: 1px solid black;"><div class="Total"><h6>'.$ItemSaleQueryObj->ItemPrice.'</h6></div></td>';
					echo '<td style="border: 1px solid black;"><div class="NogollasCategory"><h6>'.$ItemSaleQueryObj->NogollasCategory.'</h6></div></td>';  						
					echo '</tr>';	
				}
			}
			else {
					echo '<div class="store-Instruct">';
					echo '<h4>There is no record of any transaction. Start Shopping!</h4>';
					echo '</div>';
			}
			//Release Memory
			$ItemSaleQuery=0; $ItemSaleQueryNumRows=0; $ItemSaleQueryObj=0;
			?>
			</tbody>
		</table>
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