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
	
	<!--Content Section-->
	<div class="row"  id="Customer2">	
		<h4> Fill in the information below to post item for SALE </h4>
		<ul class="small-block-grid-1 medium-block-grid-2 large-block-grid-2" data-equalizer>
			<li class="PostItemFrame1">
				<form id="SellItemForm" name="SellItemForm" action="./func-createitem.php" method="post" enctype="multipart/form-data" data-abide>
			
				<label for="ItemName">Item Name <small>Required</small></label> 
				<input type="text" name="ItemName" placeholder="Item Name" required />
				<small class="error">Item Name is mandatory</small>
				
				<label for="ItemDescription">Item Description <small>Required</small></label>
				<textarea name="ItemDescription" placeholder="Description/Measurement" required rows="5"></textarea>
				<small class="error">Description/Measurement is mandatory</small>
				
				<label for="ItemPrice">Price offering (exclusive of freight costs) <small>Required</small></label>
				<input type="text" name="ItemPrice" required pattern="\d+(\.\d{2})?" placeholder="Price" />
				<small class="error">Price is mandatory</small>	
				
				<label for="ItemInstruction">Instruction For Buyer <small>Required</small></label>
				<input type="text" name="ItemInstruction" placeholder="Instruction For Buyer" required />
				<small class="error">Instruction For Buyer is mandatory</small>	
			</li>
			
			<li class="PostItemFrame2">
				<p></p>
				<select name ="ItemSize" id ="ItemSize">
				<option value="" disabled="disabled" selected="selected"> Select Size</option>
				<option value="XS">XS</option>
				<option value="S">S</option>
				<option value="M">M</option>
				<option value="L">L</option>
				<option value="XL">XL</option>
				</select>
						
				<select name = "ItemCondition">
				<option value="" disabled="disabled" selected="selected"> Select Item Condition</option>
				<option value="BNIB">BNIB</option>
				<option value="BRAND NEW">BRAND NEW</option>
				<option value="WORN ONCE">WORN ONCE</option>
				<option value="WORN">WORN</option>
				</select>
				
				<select name = "ItemDelivery">
				<option value="" disabled="disabled" selected="selected"> Select Mode of Delivery</option>
				<option value="MEET UP ONLY">MEET UP ONLY</option>
				<option value="NORMAL MAIL">NORMAL MAIL</option>
				<option value="REGISTERED MAIL">REGISTERED MAIL</option>
				</select>
				
				<select name ="ItemSellingMode">
				<option value="" disabled="disabled" selected="selected"> Select Selling Mode</option>
				<option value="SELL ONLY">SELL ONLY</option>
				<option value="TRADE ONLY">TRADE ONLY</option>
				<option value="SELL AND TRADE">SELL AND TRADE</option>
				</select>
				
				<label for="ItemCategory">Item Category</label> 
				<?php
				echo '<select name="ItemCategory">';
				$CategoryQuery = $mysqli->query("SELECT CategoryID, Category, SubCategory FROM Categorys");
				$CategoryQueryNumRows = mysqli_num_rows($CategoryQuery);
				while($CategoryQueryObj = $CategoryQuery->fetch_object()) {
					echo '<option value="'.$CategoryQueryObj->CategoryID.'">'.$CategoryQueryObj->Category.'-'.$CategoryQueryObj->SubCategory.'</option>';
				}
				echo "</select>";
				?>
				
				<p></p>		
				<label for="Filename">Select Image to Upload (Accept Only: gif/jpg and Max Image Size < 100KB)</label>
				<input type="file" name="Filename" id="Filename"required />
			
			</li>
		</ul>	
		<div class="PostItemFrame3" align ="center"> <input id="SubmitBtn" name="SubmitBtn" type='submit' onclick="Validate()" value="Submit">
		<!--<button id="SubmitBtn" class="SubmitBtn" onclick="Validate()" value="Submit" > Submit </button></div> -->
		</form>				
	</div>
	
	<script type="text/javascript">
		function Validate(){
		   //check select
			if(document.getElementById('ItemSize').value == 'Select Size'){
				lert('Please Select a Size!!!');
			}
		}
	</script>
	<?php
	include('footer.php'); 
	include('script.php');
	?>
  </body>
</html>
	