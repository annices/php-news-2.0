<?php

// Files needed to connect to database:
include_once 'config/database.php';
include_once 'objects/admin.php';

// Connect to database:
$database = new Database();
$db = $database->getConnection();


// If create user:
if($_POST['user']) {

	// Get submitted data:
	$username = $_POST['username'];
	$password = $_POST['password'];

	// Instantiate admin object:
	$user = new Admin($db);

	// Set admin property values:
	$user->username = $username;
	$user->password = $password;

	// Create the admin user:
	if(strlen($username) != 0 && strlen($password) != 0) {

		$user->createAdmin();

		// Redirect user to an admin page:
		header('Location: login.php');

		// For security reasons, remove this file after admin has been created:
		unlink('create_user.php');
	}
	else{
		$feedback = "<span class='errormsg'>ERROR: Please fill in the manditory fields.</span>";
	}

}

?>

<!DOCTYPE html>
<!--
This news script was fetched from https://annice.se and is created by Annice Strömberg, 2019.
-->
<html>
<head>
	<title>News 2.0</title>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link href="css/style.css" rel="stylesheet">

</head>
<body>

	<h1>Create Admin User</h1>

	<?php
    // Print out feedback:
	if ($feedback != "") {
		echo "<p class='errormsg'>$feedback</p>";
	}
	?>

	<div id="container">
		<p><em>NOTE! For security reasons, this page will be deleted once you have created the user.
			However, you will be able to update your admin credentials later via a user edit page.</em></p>

			<form method="post" action="create_user.php">
				<div class="row">
					<div class="col-25">
						Your Username: <span style="color: red">*</span>
					</div>
					<div class="col-75">
						<input name="username" type="text" size="50">
					</div>
				</div>
				<div class="row">
					<div class="col-25">
						Your Password: <span style="color: red">*</span>
					</div>
					<div class="col-75">
						<input name="password" type="text" size="50">
					</div>
				</div>
				<div class="row">
					<input type="submit" name="user" value="Create User">
				</div>
			</form>
		</div>

	</body>
</html>