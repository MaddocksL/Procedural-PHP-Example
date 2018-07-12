<?php
	include_once 'templates/header.php';
?>
<section class="main-container">
	<div class="main-wrapper">

<?php
if (isset($_GET["id"])) {
	require "includes/dbh.php";

	$articleId = $_GET["id"];

	$query = "SELECT ID, Title, Content, Author, Date, DateEdit, Image, ImageType FROM articles WHERE ID = '$articleId'";
	$result = mysqli_query($conn, $query)
		or die('Error querying the database');

	if (mysqli_num_rows($result) == 0) {
		echo("No results found");
	} else {
		while($row = mysqli_fetch_assoc($result)) {
			$image = $row["Image"];
			echo '<img src="data:'.$row["ImageType"].';base64, '.base64_encode($image).'" />';
			echo(" <h2>".$row["Title"]. "</h2><h2> by ".$row["Author"]."</h2><br>");
			echo($row["Content"]."<br><br>");
			echo("Date last edited: ".$row["DateEdit"]."<br>");
		}
	}
	
	mysqli_close($conn);
} else {
	header("Location: index.php");
}
?>
	</div>
</section>
<?php
	include_once 'templates/footer.php';
?>