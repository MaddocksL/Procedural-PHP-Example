<?php
	include 'templates/header.php';
?>

<section class="main-container">
	<div class="main-wrapper">
		<h2>Sign Up</h2>
		<form class="signup-form" action="includes/signup.inc.php" method="POST">
			<input type="text" name="first" placeholder="First name">
			<input type="text" name="last" placeholder="Last name">
			<input type="Email" name="email" placeholder="Email">
			<input type="text" name="user" placeholder="Username">
			<input type="password" name="pwd" placeholder="Password">
			<button type="Submit" name="submit">Sign Up</button>
		</form>
	</div>
</section>

<?php
	include_once 'templates/footer.php';
?>