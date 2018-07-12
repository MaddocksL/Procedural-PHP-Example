<?php
// echo '<pre>' .var_dump(isset($_POST['Submit'])) . '</pre>';
// echo '<pre>' .var_dump(isset($_POST['Update'])) . '</pre>';
// echo '<pre>' .var_dump(isset($_FILES['image'])) . '</pre>';
// echo '<pre>' .var_dump(isset($_POST['image'])) . '</pre>';
// exit();

if (isset($_POST['Submit']) || isset($_POST['Update'])) {
	require("dbh.php");

	$articleTitle = mysqli_real_escape_string($conn, $_POST['title']);
	$articleContent = mysqli_real_escape_string($conn, $_POST['article']);

	if(isset($_POST['id'])){
	//$categoryLocal is checked and value = 1
	$id = mysqli_real_escape_string($conn, $_POST['id']);
	} else{
		$id='null';
	}

	if(isset($_POST['local'])){
	//$categoryLocal is checked and value = 1
	$categoryLocal = mysqli_real_escape_string($conn, $_POST['local']);
	} else{
		$categoryLocal=0;
	}

	if(isset($_POST['sport'])){
	//$categorySport is checked and value = 1
	$categorySport = mysqli_real_escape_string($conn, $_POST['sport']);
	} else{
		$categorySport=0;
	}

	if(isset($_POST['education'])){
	//$categoryEducation is checked and value = 1
	$categoryEducation = mysqli_real_escape_string($conn, $_POST['education']);
	} else{
		$categoryEducation=0;
	}

	if(isset($_POST['event'])){
	//$categoryEvent is checked and value = 1
	$categoryEvent = mysqli_real_escape_string($conn, $_POST['event']);
	} else{
		$categoryEvent=0;
	}

	if (isset($_FILES['image'])) {
		$imageTypeCompatible = mysqli_real_escape_string($conn, $_FILES['image']['type']);
		if (substr($imageTypeCompatible, 0, 5) == "image") {
			//Get the content of the image and then escape it 
			$imagetmp = mysqli_real_escape_string($conn, file_get_contents($_FILES['image']['tmp_name']));
			$imageType = mysqli_real_escape_string($conn, ($_FILES['image']['type']));
		}else {
			$upload = "false";
			$imageType = "nullCompat";
			$imagetmp = "ImageNullCompat";
		}	
	} else {
		$upload = "false";
		$imageType = "null";
		$imagetmp = "Image";
	}

	date_default_timezone_set('Europe/London');
	$date = date('Y-m-d H:i:s', time());

	if ($_POST['Submit'] == true) {
		$articleAuthor = mysqli_real_escape_string($conn, $_POST['author']);

		$sql = "INSERT INTO articles (Title, Content, Author, Date, DateEdit, Image, ImageType, LocalNews, Sport, Education, Events) 
			VALUES ('$articleTitle', '$articleContent', '$articleAuthor', '$date', '$date', '$imagetmp', '$imageType', '$categoryLocal', '$categorySport', '$categoryEducation', '$categoryEvent')";

		if ($conn->query($sql) === TRUE) {
		    header("Location: ../admin.php?update=successAdded");
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
	} elseif ($_POST['Update'] == true) {
		if ($upload == "false") {
			//Image not updated
			$sql = "UPDATE articles SET Title='$articleTitle', Content='$articleContent', DateEdit='$date', LocalNews='$categoryLocal', Sport='$categorySport', Education='$categoryEducation', Events='$categoryEvent'
			WHERE ID='$id'";
		} else {
			//Image update included in query
			$sql = "UPDATE articles SET Title='$articleTitle', Content='$articleContent', DateEdit='$date', Image='$imagetmp', ImageType='$imageType', LocalNews='$categoryLocal', Sport='$categorySport', Education='$categoryEducation', Events='$categoryEvent'
			WHERE ID='$id'";
		}


		if ($conn->query($sql) === TRUE) {
		    header("Location: ../admin.php?update=successUpdate");
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
	} else {
		echo "Failed Submitting Article";
	}

	$conn->close();
} else {
	header("Location: ../index.php");
	exit();
}
?>