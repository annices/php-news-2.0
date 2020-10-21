<?php
// Call session start to be able to set sessions:
session_start();

// Files needed to connect to database:
include_once 'config/database.php';
include_once 'objects/admin.php';

// If submit:
if ($_SERVER["REQUEST_METHOD"] == "POST") {

	// Connect to database:
	$database = new Database();
	$db = $database->getConnection();

	// Get input values from form on submit:
	$username = $_POST['username'];
	$password = $_POST['password'];

	// Instantiate admin object:
	$admin = new Admin($db);

	// Set admin property values:
	$admin->username = $username;
	$valid_login = $admin->checkLogin();

	// Check if password is correct:
	if($valid_login && password_verify($password, $admin->password)) {

		// Set a username session to keep user logged in:
		$_SESSION['user'] = $username;

		// Redirect user to an admin page:
		header('Location: newslist.php');

	}
	else{
		$feedback = "ERROR: Invalid login.";
	}

}

?>

<?php include_once 'layout/header.php'; ?>

	<h1>Admin Login</h1>

	<div id="container">

		<?php
        // Print feedback:
		if(isset($_SESSION['user']))
			echo "<p>[<a href='logout.php'>Logout</a>]</p>";
		else {
			echo "<p class='errormsg'>$feedback</p>";
			?>

			<form method="post" action="login.php">
				<div class="row">
					<div class="col-25">
						Username: <span style="color: red">*</span>
					</div>
					<div class="col-75">
						<input name="username" type="text" size="50" maxlength="100">
					</div>
				</div><div class="row">
				<div class="col-25">
					Password: <span style="color: red">*</span>
				</div>
				<div class="col-75">
					<input name="password" type="password" size="50" maxlength="100">
				</div>
			</div><div class="row">
			<input type="submit" value="Login">
		</div>
	</form>

	<?php } // End else ?>

</div>

<?php include_once 'layout/footer.php'; ?>