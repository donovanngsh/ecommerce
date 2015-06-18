<?php

//declare database connection
include('./functions/db_connect/db_connect.php');

//declare variables
global $mysqli;
session_start();
if(!isset($_SESSION['CustomerID']))
{
	header("Location: login.php?status=notLogged");
}
?>


  
	<!--Content Section-->
	<div class="row"  id="Customer2">
	<h4> Maintain Account Information </h4>	
		
			<ul class="small-block-grid-1 medium-block-grid-2 large-block-grid-2" data-equalizer>
				<li class="MyAccountFrame1">
				<h5> Your Account Details</h5>
				<?php
					//Retrieve all Requested Items
					$CustomerInfoQuery = $mysqli->query("SELECT CustomerID, UserName, Email, Gender, Birthday 
					From Customer Where CustomerID = ".$_SESSION['CustomerID']." ");
								
					//count array row
					$CustomerInfoQueryNumRows = mysqli_num_rows($CustomerInfoQuery);
				
					If ($CustomerInfoQueryNumRows > 0){	
						//Populate Items for Sale
						while($CustomerInfoQueryObj = $CustomerInfoQuery->fetch_object()) {
							echo '<p></p>';
							echo '<div class="UserName"><b>UserName			: </b>'.$CustomerInfoQueryObj->UserName.' </div>';
							echo '<p></p>';
							echo '<div class="Email"><b>Email			: </b>'.$CustomerInfoQueryObj->Email.' </div>';
							echo '<p></p>';
							echo '<div class="Gender"><b>Gender			: </b>'.$CustomerInfoQueryObj->Gender.' </div>';
							echo '<p></p>';
							echo '<div class="Birthday"><b>Birthday			: </b>'.$CustomerInfoQueryObj->Birthday.' </div>';
						}
					}
					else {
						echo '<div class="store-Instruct">';
						echo '<h4>Error. Please Contact Nogollas Admin at nogollasadmin@hotmail.com.</h4>';
						echo '</div>';
					}
				?>
				</li>
				<li class="MyAccountFrame2">
				<form action="./func-updateaccount.php" method="post" data-abide>
				
				<h5> Edit any of the fields below to keep your account updated</h5>
				<label>Password 
				<input type="password" name="password" id="password" pattern="[a-zA-Z0-9]+" placeholder="Enter your password" />
				</label>
				<small class="error">Password should contain at least 9 characters.</small>
		
				<select name ="gender">
				<option value="" disabled="disabled" selected="selected"> Select Your Gender</option>
				<option value="MALE">MALE</option>
				<option value="FEMALE">FEMALE</option>
				</select>
				
				<div class="birthday-field">
					<label>Birthday
						<input type="text" name="birthday" pattern="month_day_year" placeholder="Enter your birthday in MM/DD/YYYY">
					</label>
					<small class="error">Valid birthday is required in MM/DD/YYYY.</small>
				</div>

				<div class="MyAccountFrame3" align ="right"> <button type="submit">Submit</button> </div>
				</form>	
				</li>
			</ul>
	</div>
				
	<?php 
		include('script.php');
	?>
	