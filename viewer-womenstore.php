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
	
	<div class="row" id="ViewerStore">
		<div class="WomenStore">
			<div class="panel viewstore-login">
				<h4>Please <a href="./login.php">Sign Up | Login</a> to continue</h4>
			</div>
				
			<div class="viewstore-page">
				<ul class="small-block-grid-2 medium-block-grid-4 large-block-grid-4">	
				
				<?php				
					//Upload file Path Destination
					$filePath = 'http://kinestectic.com/nogollas/nogollas-f3/UploadedFiles/';
	
					$result = $mysqli->query("
					SELECT T1.ItemID, T1.ItemName, T1.ItemSize, T1.ItemImageFileName , T2.Category
					FROM Item AS T1 INNER JOIN Categorys AS T2 ON T1.ItemCategory = T2.CategoryID
					Where T1.NOGOLLASCATEGORY='ITEM FOR SALE' And T1.ItemStatus = 1 AND T2.Category = 'WOMEN' ORDER BY ItemID DESC");
					$resultRows = mysqli_num_rows($result);
					
					if ($resultRows > 0) {
						while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
						//printf ("%s (%s)\n",$row["ItemID"],$row["ItemName"]);
						echo '<li class="Item th radius">';
						echo '<img src="'.$filePath.$row["ItemImageFileName"].'" />';
						echo '<div class="ItemName" align = "center"><h6>'.$row["ItemName"].'</h6></div>';
						echo '<div class="ItemSize" align = "center"><h6>'.$row["ItemSize"].'</h6></div>';
						//echo '<img src="thumbnail.php?id='.$row["ItemID"].'&filename='.$row["ItemImageFileName"].'" />';
						echo '</li>';
						}
					} else {
						echo '<div align="center">';
						echo '<h3>Items NOT Available. Please Check Back Again Later.</h3>';
						echo '</div>';	
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
	include('footer.php'); 
	include('script.php');
?>
</body>