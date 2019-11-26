
<?php
$isInserted = "";
var_dump($_POST);
// Check that all required fields have been passed to this page
if ( !isset($_POST['title']) || 
	empty($_POST['title']) ) {
	$error = "Please fill out a title.";
}
else {
	// Connect to the db
	$host = "303.itpwebdev.com";
	$user = "kseyoum_db_user";
	$pass = "10534303Abc!";
	$db = "kseyoum_dvd_db";
	$mysqli = new mysqli($host, $user, $pass, $db);
	if ( $mysqli->errno ) {
		echo $mysqli->error;
		exit();
		}
		$mysqli->set_charset('utf8');
			// SQL statement to INSERT new record into the DB.
		//release date
		if(!isset($_POST['release_date'])||empty($_POST['release_date'])){

			$release_date = null;
		}
		else{

			$release_date = $_POST['release_date'];
		}

		if(!isset($_POST['label_id'])||empty($_POST['label_id'])){
			$label_id = null;
		}
		else{
			$label_id = $_POST['label_id'];
		}

		if(!isset($_POST['sound_id'])||empty($_POST['sound_id'])){
			$sound_id = null;
		}
		else{
			$sound_id = $_POST['sound_id'];
		}

		if(!isset($_POST['genre_id'])||empty($_POST['genre_id'])){
			$genre_id = null;
		}
		else{
			$genre_id = $_POST['genre_id'];
		}

		if(!isset($_POST['rating_id'])||empty($_POST['rating_id'])){
			$rating_id = null;
		}
		else{
			$rating_id = $_POST['rating_id'];
		}

		if(!isset($_POST['award'])||empty($_POST['award'])){
			$award = null;
		}
		else{
			$award = $_POST['award'];
		}
		
		
		


		
		


		////////
		////////
		////////

		// if ( isset($_POST['release_date']) && !empty($_POST['release_date']) ) {
		// 	$release_date =  $_POST['release_date'] ;
		// } else {
		// 	$release_date = null;
		// }

		// if ( isset($_POST['label']) && !empty($_POST['label']) ) {
		// 	$label =  $_POST['label'] ;
		// } else {
		// 	$label = null;
		// }

		// if ( isset($_POST['sound']) && !empty($_POST['sound']) ) {
		// 	$sound =  $_POST['sound'] ;
		// } else {
		// 	$sound = null;
		// }

		// if ( isset($_POST['genre']) && !empty($_POST['genre']) ) {
		// 	$genre =  $_POST['genre'] ;
		// } else {
		// 	$genre = null;
		// }

		// if ( isset($_POST['rating']) && !empty($_POST['rating']) ) {
		// 	$rating =  $_POST['rating'] ;
		// } else {
		// 	$rating = null;
		// }

		// if ( isset($_POST['format']) && !empty($_POST['format']) ) {
		// 	$format =  $_POST['format'] ;
		// } else {
		// 	$format = null;
		// }

		// if ( isset($_POST['award']) && !empty($_POST['award']) ) {
		// 	$award =  $_POST['award'] ;
		// } else {
		// 	$award = null;
		// }


	$sql_prepared = "INSERT INTO dvd_titles(title, release_date, award, label_id, sound_id, genre_id, rating_id, format_id) VALUES(?,?,?,?,?,?,?,?);";

	$statement = $mysqli->prepare($sql_prepared);
		// First parameter is data types, the rest are variables that will fill in the ? placeholders
		$statement->bind_param("sssiiiii", $_POST["title"], $release_date, $award, $label_id, $sound_id, $genre_id, $rating_id, $format_id);
		$executed = $statement->execute();
		// execute() will return false if there's an error
		if(!$executed) {
			echo $mysqli->error;
			exit();
		}
		// affected_rows returns how many records were affected (updated/deleted/inserted)
		if( $statement->affected_rows == 1 ) {
			$isInserted = true;
		}
		else
		{
			echo "kdjfa";
		}
		$statement->close();
		$mysqli->close();

	}



?>



<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add Confirmation | DVD Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="add_form.php">Add</a></li>
		<li class="breadcrumb-item active">Confirmation</li>
	</ol>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Add a DVD</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">

			<div class="text-danger font-italic">
			<?php if(isset($error) && !empty($error)) : ?>
				<div class="text-danger">
					<?php echo $error; ?>
				</div>
			<?php endif; ?>
			</div>



				<div class="text-success"><span class="font-italic"> <?php$_POST['title']?></span> <?php if($isInserted==true) : ?>
				<div class="text-success">
					 was successfully added.
				</div>

			<?php endif; ?>
		</div>

			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="add_form.php" role="button" class="btn btn-primary">Back to Add Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>