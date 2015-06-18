<div class="row">
	<div class="medium-6 large-6 columns">
		<h3>Log In</h3>
		<div class="login"> 
			<?php
				$error = $_GET['error'];
				if ($error == "noMatch") {
					echo "<div class=\"failValidate\">";
					echo "<p>Sorry, Username and password do not match.</p>";
					echo "</div>";
				}
			?>
			<form action="./functions/login/func_login.php" method="post" data-abide>
				<div class="name-field">
				    <label>Username <small>required</small>
						<input type="text" name="user" required pattern="alpha_numeric" placeholder="Enter your username" />
					</label>
					<small class="error">Name is required and should be alphanumeric.</small>
				</div>
				<div class="password-field">
					<label>Password <small>required</small>
						<input type="password" name="password" required placeholder="Enter your password" />
					</label>
					<small class="error">Password is required.</small>
				</div>
				<button type="submit">Submit</button>
			</form> 
		</div>
	</div>
	<div class="medium-6 large-6 columns"> 
		<h3>Dont have an Account?</h3>
		<h5 class="subheader">Create an account with us by filling out the blanks below.</h5>
		
		<?php
		$error = $_GET['error'];
		if ($error == "bothExists")
		{
			echo "<div class=\"failValidate\">";
			echo "<p>Sorry, username and email are used.</p>";
			echo "</div>";
		}
		if ($error == "userExists")
		{
		    echo "<div class=\"failValidate\">";
			echo "<p>Sorry, the user is already in use. Please use another username.</p>";
			echo "</div>";
		}
		if ($error == "emailExists") 
		{
		    echo "<div class=\"failValidate\">";
			echo "<p>Sorry, the email is already registered in our system.</p>";
			echo "</div>";
		}
		?>
		
		<div class="signup">
			<form action="./functions/login/func_signup.php" method="post" data-abide>
				<div class="name-field">
					<label>Username <small>required</small>
						<input type="text" name="user" required pattern="alpha_numeric" placeholder="Enter your username" />
					</label>
					<small class="error">Name is required should be alphanumeric.</small>
				</div>
				<div class="email-field">
					<label>Email <small>required</small>
						<input type="email" name="email" required placeholder="Enter your email">
					</label>
					<small class="error">Valid email is required.</small>
				</div>
				<div class="password-field">
					<label>Password <small>required</small>
						<input type="password" name="password" id="password" required pattern="[a-zA-Z0-9]+" placeholder="Enter your password" />
					</label>
					<small class="error">Password is required.</small>
				</div>
				<div class="password-confirmation-field">
					<label>Confirm Password <small>required</small>
						<input type="password" required pattern="[a-zA-Z0-9]+" data-equalto="password" placeholder="Enter your password" />
					</label>
					<small class="error">The password did not match</small>
				</div>
				
				<select name ="gender">
				<option value="" disabled="disabled" selected="selected"> Select Your Gender</option>
				<option value="MALE">MALE</option>
				<option value="FEMALE">FEMALE</option>
				</select>
				
				<div class="birthday-field">
					<label>Birthday <small>required</small>
						<input type="text" name="birthday" required pattern="month_day_year" placeholder="Enter your birthday in MM/DD/YYYY">
					</label>
					<small class="error">Valid birthday is required in MM/DD/YYYY.</small>
				</div>
				  
				<button type="submit">Submit</button>
			</form>
		</div>
	</div>