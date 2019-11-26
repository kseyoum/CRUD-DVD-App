
<?php
	
	

	// Quick check to see what info got sent from edit_form.php
	var_dump($_POST);

	$isUpdated = false;
	// Make sure required fields are set
	if ( !isset($_POST['title']) || empty($_POST['title']) ) {
		$error = "Please fill out the title fields.";
	}
	else {

				// Check that the dvd_title_id has been passed to this page
			if( !isset($_POST["dvd_title_id"]) || empty($_POST["dvd_title_id"]) ) {
				echo "Invalid DVD";
				exit();
			}
			$host = "303.itpwebdev.com";
			$user = "kseyoum_db_user";
			$pass = "10534303Abc!";
			$db = "kseyoum_dvd_db";

			// DB Connection
			$mysqli = new mysqli($host, $user, $pass, $db);
			if ( $mysqli->connect_errno ) {
				echo $mysqli->connect_error;
				exit();
			}

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
				WHERE dvd_title_id =" . $_POST["dvd_title_id"]  . ";";
				$results_placeholder = $mysqli->query($sql);
				$row_ph = $results_placeholder->fetch_assoc();
				if ($results_placeholder == false) 
				{
				echo $mysqli->error;
				exit();
				}

			$mysqli->set_charset('utf8');

		}
		// Cover optional field
		if ( isset($_POST['release_date']) && !empty($_POST['release_date']) ) {
			$release_date = "'".$_POST['release_date']."'" ;
		} else if(!empty($row_ph["release_date"])){

			$release_date=$row_ph["release_date"];

		}
		else
		{
			$release_date = 'null';
		}

		if ( isset($_POST['label']) && !empty($_POST['label']) ) {
			$label_id = $_POST['label'] ;
		} else {
			$label_id = 'null';
		}

		if ( isset($_POST['sound']) && !empty($_POST['sound']) ) {
			$sound_id = $_POST['sound'] ;
		} else {
			$sound_id = 'null';
		}

		if ( isset($_POST['genre']) && !empty($_POST['genre']) ) {
			$genre_id = $_POST['genre'] ;
		} else {
			$genre_id = 'null';
		}

		if ( isset($_POST['rating']) && !empty($_POST['rating']) ) {
			$rating_id = $_POST['rating'] ;
		} else {
			$rating_id = 'null';
		}

		if ( isset($_POST['format']) && !empty($_POST['format']) ) {
			$format_id = $_POST['format'] ;
		} else {
			$format_id = 'null';
		}

		if ( isset($_POST['award']) && !empty($_POST['award']) ) {
			$award = "'".$_POST['award']."'";
		} else {
			$award = 'null';
		}

		echo $_POST["title"];

		$sql = "UPDATE dvd_titles SET title = '" . $_POST['title'] . "', dvd_titles.release_date = ". $release_date . ", dvd_titles.label_id = " . $label_id . ", dvd_titles.sound_id = ". $sound_id . ", dvd_titles.genre_id = " . $genre_id . ", dvd_titles.rating_id = " . $rating_id . ", dvd_titles.format_id = " . $format_id . ", award = " . $award ." WHERE dvd_title_id = " . $_POST['dvd_title_id'] .";";


		//Using prepared statements instead (to prevent SQL injections)
		// $sql_prepared = "UPDATE dvd_titles SET title = ?, release_date = ?, award = ?, label_id = ?, sound_id = ?, genre_id = ?, rating_id = ?, format_id = ? WHERE dvd_title_id = ?;";

		echo $sql;

		$results = $mysqli->query($sql);

		if (!$results)
		 {
		 		echo $mysqli->error;
		 		exit();


		 }
		 else{
		 	echo "KDJDLK";
		 }
		 if (isset($results) && !empty($results)) {
				$isUpdated = true;		 
			}
			else{
				echo "kdjfal";
			}
		 $mysqli->close();





		// $statement = $mysqli->prepare($sql_prepared);
		// // First parameter is data types, the rest are variables that will fill in the ? placeholders
		// $statement->bind_param("sssiiiiii", $_POST["title"], $release_date, $award, $label_id, $sound_id, $genre_id, $rating_id, $format_id, $_POST["dvd_title_id"]);
		// $executed = $statement->execute();
		// // execute() will return false if there's an error
		// if(!$executed) {
		// 	echo $mysqli->error;
		// }
		// // affected_rows returns how many records were affected (updated/deleted/inserted)
		// if( $statement->affected_rows == 1 ) {
		// 	$isUpdated = true;
		// }
		// else
		// {
		// 	echo "kdjfa";
		// }
		// $statement->close();
		// $mysqli->close();
	
?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Confirmation | DVD Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item"><a href="search_results.php">Results</a></li>
		<li class="breadcrumb-item"><a href="details.php">Details</a></li>
		<li class="breadcrumb-item"><a href="edit_form.php">Edit</a></li>
		<li class="breadcrumb-item active">Confirmation</li>
	</ol>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Edit a DVD</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">

				<?php if ( isset($error) && !empty($error) ) : ?>
					<div class="text-danger">
						<?php echo $error; ?>
					</div>
				<?php endif; ?>

				<?php if ($isUpdated) : ?>
					<div class="text-success">
						<span class="font-italic"><?php echo $_POST['title']; ?></span> was successfully edited.
					</div>
				<?php endif; ?>

			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="details.php?dvd_title_id=<?php echo $_POST['dvd_title_id']?>" role="button" class="btn btn-primary">Back to Details</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>