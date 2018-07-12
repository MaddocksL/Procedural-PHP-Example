<?php

if (isset($_POST['submit'])) {

	require 'dbh.php';
	$first = mysqli_real_escape_string($conn, $_POST['first']);
	$last = mysqli_real_escape_string($conn, $_POST['last']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$user = mysqli_real_escape_string($conn, $_POST['user']);
	$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

	//Error handling

	//Check for empty fields
	if (empty($first) || empty($last) || empty($email) || empty($user) || empty($pwd)) {
		header("Location: ../signup.php?signup=empty");
		exit();
	} else {
		//Check if input is valid
		if (!preg_match("/^[a-zA-Z]*$/", $first) || !preg_match("/^[a-zA-Z]*$/", $last)) {
			header("Location: ../signup.php?signup=invalid");
			exit();
		} else {
			// Check if email is valid
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				header("Location: ../signup.php?signup=email");
				exit();
			} else {
				$sql = "SELECT * FROM users WHERE user_uid='$user'";
				$result = mysqli_query($conn, $sql);
				$resultCheck = mysqli_num_rows($result);

				if ($resultCheck > 0) {
					header("Location: ../signup.php?signup=userexists");
					exit();
				} else {
					//Password Hash
					$hashedPass = password_hash($pwd, PASSWORD_DEFAULT);
					//Insert user to database
					$sql = "INSERT INTO users (firstname, lastname, user_email, username, passcode) VALUES ('$first', '$last', '$email', '$user', '$hashedPass');";

					mysqli_query($conn, $sql);
					header("Location: ../signup.php?signup=success");
					exit();
				}
			}
		}
	}

} else {
	header("Location: ../signup.php");
	exit();
}

?>