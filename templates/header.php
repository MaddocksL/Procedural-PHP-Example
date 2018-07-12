<?php
session_start();

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<header>
		<nav>
			<div class="main-wrapper">
				<ul>
					<li><a href="index.php">Home</a></li>
				</ul>
				<div class="nav-login">
					<?php
					if (isset($_SESSION['s_id'])) { 
						?>
						<form action="includes/logout.inc.php" method="POST">
							<button type="submit" name="submit">Logout</button>
						</form>
						<form action="admin.php" method="POST">
							<button type="submit" name="submit">Admin</button>
						</form>
						<?php
					} else {
						?>
						<form action="includes/login.inc.php" method="POST">
							<input type="text" name="user" placeholder="Username/email">
							<input type="password" name="pwd" placeholder="Password">
							<button type="submit" name="submit">Login</button>
						</form>
						<a href="signup.php">Sign Up</a>
						<?php
					}
					?>
				</div>
			</div>
		</nav>	
	</header>