
<?php
	var_dump($_GET);
	if( !isset( $_GET["dvd_title_id"] ) || empty($_GET["dvd_title_id"]) ) {
		// A track id is not given, show error message. Don't do anything else.
		$error = "Invalid Title ID";
	}
	else {
		// A track id is given so continue to connect to the DB.
		$host = "303.itpwebdev.com";
		$user = "kseyoum_db_user";
		$pass = "10534303Abc!";
		$db = "kseyoum_dvd_db";
		// Connect to the DB
		$mysqli = new mysqli($host, $user, $pass, $db);
		if( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
		}
		// Set the character set
		$mysqli->set_charset('utf-8');
		// Write the SQL statement
		$sql = "SELECT title, release_date, award, genres.genre AS genre, sounds.sound AS sound, labels.label AS label, formats.format AS format, ratings.rating AS rating
FROM dvd_titles
	LEFT JOIN genres
		ON dvd_titles.genre_id = genres.genre_id
	LEFT JOIN sounds
		ON  dvd_titles.sound_id = sounds.sound_id
    LEFT JOIN labels
		ON dvd_titles.label_id = labels.label_id 
	LEFT JOIN formats
		ON dvd_titles.format_id = formats.format_id 
	LEFT JOIN ratings
		ON dvd_titles.rating_id = ratings.rating_id  
WHERE dvd_title_id =" . $_GET["dvd_title_id"]  . ";";

var_dump($sql);
// Run the query on the DB
$results = $mysqli->query($sql);
if( !$results ) {
	echo "dkjflaksdj";
	echo $mysqli->error;
	exit();
}
$row = $results->fetch_assoc();
var_dump($row);
// Close the connection
$mysqli->close();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Details | DVD Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>

	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item"><a href="search_results.php">Results</a></li>
		<li class="breadcrumb-item active">Details</li>
	</ol>

	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">DVD Details</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

		<div class="row mt-4">
			<div class="col-12">

				<div class="text-danger font-italic">Display Errors Here</div>

				<table class="table table-responsive">

					<tr>
						<th class="text-right">Title:</th>
						<td><?php echo $row["title"]; ?></td>
					</tr>

					<tr>
						<th class="text-right">Release Date:</th>
						<td><?php echo $row["release_date"]; ?></td>
					</tr>

					<tr>
						<th class="text-right">Genre:</th>
						<td><?php echo $row["genre"]; ?></td>
					</tr>

					<tr>
						<th class="text-right">Label:</th>
						<td><?php echo $row["label"]; ?></td>
					</tr>

					<tr>
						<th class="text-right">Rating:</th>
						<td><?php echo $row["rating"]; ?></td>
					</tr>

					<tr>
						<th class="text-right">Sound:</th>
						<td><?php echo $row["sound"]; ?></td>
					</tr>

					<tr>
						<th class="text-right">Format:</th>
						<td><?php echo $row["format"]; ?></td>
					</tr>

					<tr>
						<th class="text-right">Award:</th>
						<td><?php echo $row["award"]; ?></td>
					</tr>

				</table>


			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="search_results.php" role="button" class="btn btn-primary">Back to Search Results</a>
			</div>
				<!-- .col -->
		</div> 

		<div class="row mt-4 mb-4">


			

			<div class="col-12">
				<a href="edit_form.php?dvd_title_id=<?php echo $_GET['dvd_title_id']?>" role="button" class="btn btn-primary">Edit DVD Info</a>
			</div> 

		</div>

		<!-- .row -->
	</div> <!-- .container -->
</body>
</html>