<div class="row">
	<div class="nogollas-icon" align ="center"><img src="./stylesheets/images/navlogo/nogollas-icon.png"></div>
</div>

<div class="row">
	<nav class="top-bar" data-topbar>
	<ul class="title-area">
    		<li class="name"></li>
     		<!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
    		<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
 	 </ul>
	  <section class="top-bar-section">
	    <!-- Nav Section -->
	    <ul class="left">
			<li class="divider"></li>
	      	<li><a href="./index.php"> HOME </a></li>
			<li class="divider"></li>
	      	<li><a href="./aboutus.php"> ABOUT US </a></li>
			
			<li class="divider"></li>
			<?php
			if(!(isset($_SESSION['CustomerID']))){
				echo '<li><a href="./viewer-womenstore.php">WOMEN</a></li>';			
			} 
			else {
				echo '<li><a href="./main-womenstore.php">WOMEN</a></li>';		
			}
			?>
			
			<li class="divider"></li>
			<?php
			if(!(isset($_SESSION['CustomerID']))){
				echo '<li><a href="./viewer-menstore.php">MEN</a></li>';			
			} 
			else {
				echo '<li><a href="./main-menstore.php">MEN</a></li>';		
			}
			?>
			
			<li class="divider"></li>
	
			<?php
			if(!(isset($_SESSION['CustomerID']))){
				echo '<li><a href="./viewer-nogollaspicks.php">NOGOLLAS PICK</a></li>';			
			} 
			else {
				echo '<li><a href="./main-nogollaspicks.php">NOGOLLAS PICK</a></li>';		
			}
			?>
			
			<li class="divider"></li>
			<?php
			if(!(isset($_SESSION['CustomerID']))){
				echo '<li><a href="./viewer-request.php">REQUESTS</a></li>';			
			} 
			else {
				echo '<li><a href="./main-allrequestitem.php">REQUESTS</a></li>';		
			}
			?>
			
			<li class="divider"></li>
			<li><a href="login.php">SIGN UP | LOGIN </a></li>
						
			<li class="divider"></li>
			<?php
			$role = '';
			if(!empty($_SESSION['role'])) {
    				$role = $_SESSION['role'];
			}
			//$role = $_SESSION['Role'];
			
			if(!(isset($_SESSION['CustomerID']))){	} 
			else {
			echo '<li><a href="#" data-dropdown="hover1" data-options="is_hover:true">My Account</a> ';
			echo '<ul id="hover1" class="f-dropdown" data-dropdown-content>';
			echo '<li><a href="./registereduser.php">Manage Account</a></li>';
			echo '<li><a href="./main-sellitem.php">Post to Item for Sale</a></li>';
			echo '<li><a href="./main-requestitem.php">Request for Item</a></li>';
			echo '<li><a href="./main-managetrans.php">Manage Transactions</a></li>';
			
			If  ($role == 'ADMIN'){
			echo '<li><a href="./main-manageadmin.php">Administration</a></li>';
			}
			echo '</ul>';
			}
			?>
			
			<li class="divider"></li>
			<?php
			if(!(isset($_SESSION['CustomerID']))){	} 
			else {
				echo '<li><a href="./functions/logout/func_logout.php" id= signout>Sign Out</a>';
			}
			?>
	    </ul>
	  </section>
	</nav>
</div>