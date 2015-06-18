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
	<h4> Fill in the information below to request for item </h4>
		<ul class="small-block-grid-1 medium-block-grid-2 large-block-grid-2" data-equalizer>
			<li class="RequestItemFrame1">
				<form action="./func-createrequestitem.php" method="post" enctype="multipart/form-data" data-abide>
				<label for="ItemName">Item Name <small>Required</small></label> 
				<input type="text" name="ItemName" placeholder="Item Name" required />
				<small class="error">Item Name is mandatory</small>
				
				<select name ="ItemSize">
				<option value="" disabled="disabled" selected="selected"> Select Size</option>
				<option value="XS">XS</option>
				<option value="S">S</option>
				<option value="M">M</option>
				<option value="L">L</option>
				<option value="XL">XL</option>
				</select>
			
				<label for="Filename">Select Image to Upload (Accept Only: gif/jpg and Max Image Size < 100KB)</label>
				<input type="file" name="Filename" id="Filename"required />
			</li>
		
			<li class="RequestItemFrame2">
				<label for="ItemRemarks">Remarks <small>Required</small></label>
				<textarea name="ItemRemarks" placeholder="Remarks" required rows="5"/></textarea>
				<small class="error">Remarks is mandatory</small>
			</li>
			<?php
			$setNogollasCategory =3 // Request Item;
			?>
			<div class="RequestItemFrame3" align ="center"> <button class="SubmitBtn" value="Submit" > Submit </button></div>
		</ul>	
		
		</form>
					
	</div>
	
	<?php
	include('footer.php'); 
	include('script.php');
	?>
  </body>
</html>
	