
  
<?php

// Check that the dvd_title_id has been passed to this page
if( !isset($_GET["dvd_title_id"]) || empty($_GET["dvd_title_id"]) ) {
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

	$mysqli->set_charset('utf8');

	$sql = "SELECT * FROM genres;";
	$results_genres = $mysqli->query($sql);
	$row_genres = $results_genres->fetch_assoc();


	if ($results_genres == false) 
	{
		echo $mysqli->error;
		exit();
	}

	$sql = "SELECT * FROM ratings;";
	$results_ratings = $mysqli->query($sql);
	$row_ratings = $results_ratings->fetch_assoc();


	if ($results_ratings == false) 
	{
		echo $mysqli->error;
		exit();
	}


	$sql = "SELECT * FROM labels;";
	$results_labels = $mysqli->query($sql);
	$row_labels = $results_labels->fetch_assoc();



	if ($results_labels == false) 
	{
		echo $mysqli->error;
		exit();
	}

	$sql = "SELECT * FROM formats;";
	$results_formats = $mysqli->query($sql);
	$row_formats = $results_formats->fetch_assoc();


	if ($results_formats == false) 
	{
		echo $mysqli->error;
		exit();
	}

	$sql = "SELECT * FROM sounds;";
	$results_sounds = $mysqli->query($sql);
	$row_sounds = $results_sounds->fetch_assoc();


	if ($results_sounds == false) 
	{
		echo $mysqli->error;
		exit();
	}

	$sql = "SELECT dvd_title_id FROM dvd_titles;";
	$results_id = $mysqli->query($sql);


	if ($results_id == false) 
	{
		echo $mysqli->error;
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
				WHERE dvd_title_id =" . $_GET["dvd_title_id"]  . ";";
				$results_placeholder = $mysqli->query($sql);
				$row_ph = $results_placeholder->fetch_assoc();
				if ($results_placeholder == false) 
	{
		echo $mysqli->error;
		exit();
	}







	// Get details of this dvd
	$sql_title = "SELECT * FROM dvd_titles 
	WHERE dvd_title_id = " . $_GET["dvd_title_id"] . ";";
	$results_title = $mysqli->query($sql_title);
	if( !$results_title ) {
		echo $mysqli->error;
		exit();
	}
	// We'll get ONE dvd back 
	$row = $results_title->fetch_assoc();
	var_dump($row);



	//close the DB
	$mysqli->close();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Form | DVD Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<style>
		.form-check-label {
			padding-top: calc(.5rem - 1px * 2);
			padding-bottom: calc(.5rem - 1px * 2);
			margin-bottom: 0;
		}
	</style>
</head>
<body>

	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item"><a href="search_results.php">Results</a></li>
		<li class="breadcrumb-item"><a href="details.php?dvd_title_id=<?php echo $_GET['dvd_title_id']; ?>">Details</a></li>
		<li class="breadcrumb-item active">Edit</li>
	</ol>

	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4 mb-4">Edit a DVD</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

			<div class="col-12 text-danger">
				Display Error Messages Here.
			</div>

			<form action= "edit_confirmation.php" method="POST">

				<div class="form-group row">
					<label for="title-id" class="col-sm-3 col-form-label text-sm-right">Title: <span class="text-danger">*</span></label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="title-id" name="title" value="<?php echo $row['title']?>">
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<label for="release-date-id" class="col-sm-3 col-form-label text-sm-right">Release Date:</label>
					<div class="col-sm-9">
						<input type="date" class="form-control" id="release-date-id" name="release_date" value="<?php echo $row['release_date']?>">
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<label for="label-id" class="col-sm-3 col-form-label text-sm-right">Label:</label>
					<div class="col-sm-9">
						<select name="label" id="label-id" class="form-control">
							<option value="" selected><?php echo $row_ph["label"]?></option>

							<?php while( $row = $results_labels->fetch_assoc() ): ?>

									<?php if( $row["label_id"] == $row_title["label_id"]) : ?>
										<!-- Add 'selected' attribute to the genre of this track. This will make this option show up first. -->
										<option selected value="<?php echo $row['label_id']; ?>">
											<?php echo $row['label']; ?>
										</option>

									<?php else : ?>
										<!-- All other dropdown options are still shown, but does not have the 'selected' attribute -->
										<option value="<?php echo $row['label_id']; ?>">
											<?php echo $row['label']; ?>
										</option>

									<?php endif; ?>

								<?php endwhile; ?>



						</select>
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<label for="sound-id" class="col-sm-3 col-form-label text-sm-right">Sound:</label>
					<div class="col-sm-9">
						<select name="sound" id="sound-id" class="form-control">
							<option value="" selected><?php echo $row_ph['sound']?></option>


							<?php while( $row = $results_sounds->fetch_assoc() ): ?>

									<?php if( $row["sound_id"] == $row_title["sound_id"]) : ?>
										<!-- Add 'selected' attribute to the genre of this track. This will make this option show up first. -->
										<option selected value="<?php echo $row['sound_id']; ?>">
											<?php echo $row['sound']; ?>
										</option>

									<?php else : ?>
										<!-- All other dropdown options are still shown, but does not have the 'selected' attribute -->
										<option value="<?php echo $row['sound_id']; ?>">
											<?php echo $row['sound']; ?>
										</option>

									<?php endif; ?>

								<?php endwhile; ?>


						</select>
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<label for="genre-id" class="col-sm-3 col-form-label text-sm-right">Genre:</label>
					<div class="col-sm-9">
						<select name="genre" id="genre-id" class="form-control">
							<option value="" selected><?php echo $row_ph['genre']?></option>


							<?php while( $row = $results_genres->fetch_assoc() ): ?>

									<?php if( $row["genre_id"] == $row_title["genre_id"]) : ?>
										<!-- Add 'selected' attribute to the genre of this track. This will make this option show up first. -->
										<option selected value="<?php echo $row['genre_id']; ?>">
											<?php echo $row['genre']; ?>
										</option>

									<?php else : ?>
										<!-- All other dropdown options are still shown, but does not have the 'selected' attribute -->
										<option value="<?php echo $row['genre_id']; ?>">
											<?php echo $row['genre']; ?>
										</option>

									<?php endif; ?>

								<?php endwhile; ?>

						</select>
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<label for="rating-id" class="col-sm-3 col-form-label text-sm-right">Rating:</label>
					<div class="col-sm-9">
						<select name="rating" id="rating-id" class="form-control">
							<option value="" selected><?php echo $row_ph['rating']?></option>

							<?php while( $row = $results_ratings->fetch_assoc() ): ?>

									<?php if( $row["rating_id"] == $row_title["rating_id"]) : ?>
										<!-- Add 'selected' attribute to the genre of this track. This will make this option show up first. -->
										<option selected value="<?php echo $row['rating_id']; ?>">
											<?php echo $row['rating']; ?>
										</option>

									<?php else : ?>
										<!-- All other dropdown options are still shown, but does not have the 'selected' attribute -->
										<option value="<?php echo $row['rating_id']; ?>">
											<?php echo $row['rating']; ?>
										</option>

									<?php endif; ?>

								<?php endwhile; ?>

						</select>
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<label for="format-id" class="col-sm-3 col-form-label text-sm-right">Format:</label>
					<div class="col-sm-9">
						<select name="format" id="format-id" class="form-control">
							<option value="" selected><?php echo $row_ph['format']?></option>

							<?php while( $row = $results_formats->fetch_assoc() ): ?>

									<?php if( $row["format_id"] == $row_title["format_id"]) : ?>
										<!-- Add 'selected' attribute to the genre of this track. This will make this option show up first. -->
										<option selected value="<?php echo $row['format_id']; ?>">
											<?php echo $row['format']; ?>
										</option>

									<?php else : ?>
										<!-- All other dropdown options are still shown, but does not have the 'selected' attribute -->
										<option value="<?php echo $row['format_id']; ?>">
											<?php echo $row['format']; ?>
										</option>

									<?php endif; ?>

								<?php endwhile; ?>

						</select>
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<label for="award-id" class="col-sm-3 col-form-label text-sm-right">Award:</label>
					<div class="col-sm-9">
						<textarea name="award" id="award-id" class="form-control"> <?php echo $row_ph['award']?> </textarea>
					</div>
				</div> <!-- .form-group -->

				<div class="form-group row">
					<div class="ml-auto col-sm-9">
						<span class="text-danger font-italic">* Required</span>
					</div>
				</div> <!-- .form-group -->



				<input type="hidden" class="form-control" id="dvd_title_id" name="dvd_title_id" value="<?php echo $_GET['dvd_title_id']?>">

				<div class="form-group row">
					<div class="col-sm-3"></div>
					<div class="col-sm-9 mt-2">
						 <!-- <a href="edit_confirmation.php?dvd_title_id=<?php echo $_POST['dvd_title_id']?>" role= "button" type="submit" class="btn btn-primary">Submit</a>  -->
					 	<button type="submit" class="btn btn-primary">Submit</button>
						<button type="reset" class="btn btn-light">Reset</button>
					</div>
				</div> <!-- .form-group -->

			</form>

	</div> <!-- .container -->
</body>
</html>