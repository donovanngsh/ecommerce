<div class="row"> 
	<!-- 
		col1:insta sharing
		col2:released articles
		col2:contact us -->
	
	<ul class="medium-block-grid-3 large-block-grid-3" data-equalizer>
		<li id="footer-1" data-equalizer-watch>
			<h3>Nogollas's Pick</h3>
			<p>Know the WHAT's and HOW's to wear affordable and trendy clothings</p>
		</li>
		<li id="footer-2" data-equalizer-watch>
			<p>We believe in creating wonderful experiences even when shopping online.</p>
			<p>We are currently an online platform that allows anyone to buy, sell or trade.</p>
			<p>Feel free to contact us or directly email us at <a href="mailto:admin@nogollas.com">admin@nogllas.com</a></p>
		</li>
		<li id="footer-3" data-equalizer-watch>
			<h3>Mailing List</h3>
			<p>Stay informed by receiving email notifcations from us!</p>
			<!--function: 
				1.Name 
				2.Email 
			 -->
			<form id="mailinglist" method="post" action="./functions/mailing_list/func_mailinglist.php" data-abide>
				<div class="row">
					<div class="small-12 medium-12 large-12 columns">
						<div class="name-field">
							<label for="name">Name <small>required</small></label>
							<input type="text" name="name" id="name-field" required pattern="[a-zA-Z]+" placeholder="Please enter your name" />
							<small class="error">Name is required and must be a string.</small>
						</div>
						
						
						<div class="email-field">
							<label for="email">Email <small>required</small></label>
							<input type="text" name="email" id="email-field" required placeholder="Please enter your email" />
							<small class="error">An email address is required.</small>
						</div>
						
						<!-- submit button -->
						<button type="submit" name="submit" class="right">Subscribe</button>
					</div>
				</div>
			</form>
		</li>
	</ul>

	
	<!-- Copyright -->
	<div class="row">
		<div class="small-12 medium-12 large-12 columns">
			<div class="social-btns">
			<a class="social-btns-item" href="http://facebook.com"><i class="fa fa-facebook-square fa-2x"></i></a>
			<a class="social-btns-item" href="http://instagram.com"><i class="fa fa-instagram fa-2x"></i></a>
			<a href="http://twitter.com"><i class="fa fa-twitter fa-2x"></i></a>
			</div>
		</div>
		<div class="small-12 medium-12 large-12 columns" id="bottom-links">
			<p>Company Policy | Terms & Conditions | FAQ</p>
		</div>
		<div class="small-12 medium-12 large-12 columns" id="copyright">
			<p>Copyright © 2014 <a href="./index.php">Nogollas</a>.</p>
		</div>
	</div>
</div>