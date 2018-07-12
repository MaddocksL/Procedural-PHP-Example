<?php
	include_once 'templates/header.php';
	require 'includes/dbh.php';
?>

<section class="main-container">
	<div class="main-wrapper">
		<h2>Home</h2>
		<?php
		$query = "SELECT * FROM articles ORDER BY Date";
			$result = mysqli_query($conn, $query)
				or die('Error querying the database');

			if (mysqli_num_rows($result) == 0) {
				echo("No results found");
			} else {
				while($row = mysqli_fetch_assoc($result)) {
					$image = $row["Image"];
					$snippet = mb_substr($row["Content"], 0, 100); ?>

					<div>
						<a href="article.php?id= <?php echo $row['ID']; ?>">
							<span style="display: flex;">
								<span style="padding-top: 3%; padding-left: 200px; position: absolute;">
									<?php echo $snippet; ?><br><br>
								</span>
								<span style=" height: 200px; width: 200px; overflow: hidden;">
									<img style="height: 200px;" src="data:<?php echo $row["ImageType"]; ?>;base64, <?php echo base64_encode($image); ?>" />
								</span><br><br>
									<span><b><?php echo $row["Title"]; ?></b> by <?php echo $row["Author"]; ?></span>
								<br><br>
							</span>
						</a>
					<hr>
					<?php
				}
			}
			
			mysqli_close($conn);
		?>
	</div>
</section>

<?php
	include_once 'templates/footer.php';
?>