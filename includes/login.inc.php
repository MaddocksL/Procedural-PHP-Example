<?php

session_start();

if (isset($_POST['submit'])) {

	require 'dbh.php';

	$user = mysqli_real_escape_string($conn, $_POST['user']);
	$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

	//Error Handling
	//Check if inputs are empty
	if (empty($user) || empty($pwd)) {
		header("Location: ../index.php?login=empty");
		exit();
	} else {
		$sql = "SELECT * FROM users WHERE username='$user' OR user_email='$user'";
		$result = mysqli_query($conn, $sql);
		$resultCheck = mysqli_num_rows($result);
		if ($resultCheck < 1) {
			header("Location: ../index.php?login=error");
			exit();
		} else {
			if ($row = mysqli_fetch_assoc($result)) {
				$hashedPwdCheck = password_verify($pwd, $row['passcode']);
				if ($hashedPwdCheck == false) {
					header("Location: ../index.php?login=error");
					exit();
				} elseif ($hashedPwdCheck == true) {
					//Log in
					$_SESSION['s_id'] = $row['id'];
					$_SESSION['s_first'] = $row['firstname'];
					$_SESSION['s_last'] = $row['lastname'];
					$_SESSION['s_email'] = $row['user_email'];
					$_SESSION['s_user'] = $row['username'];
					header("Location: ../index.php?login=success");
					exit();
				}
			}
		}
	} 
} else {
	header("Location: ../index.php?login=error");
	exit();
}

?>