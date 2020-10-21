<?php
session_start();

// If admin is not logged in:
if (!isset($_SESSION['user'])) {
  // Redirect to login page:
  header('Location: login.php');
}

// Files needed to connect to database:
include_once 'config/database.php';
include_once 'objects/admin.php';

// Connect to database:
$database = new Database();
$db = $database->getConnection();

// Instantiate admin object:
$admin = new Admin($db);
$admin->username = $_SESSION['user'];

// If matching record ID is fetched from database:
if($admin->getAdminId()) {

  // Assign variables with fetched object property values:
  $id = $admin->{'id'};
  $username = $admin->{'username'};
  $password = $admin->{'password'};

}
else
  $feedback = "<span class='errormsg'>ERROR: Could not get record ID.</span>";


// If submit:
if($_SERVER["REQUEST_METHOD"] == "POST") {

  $id = $_POST['id'];
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Assign admin property values:
  $admin->id = $id;
  $admin->username = $username;
  $admin->password = $password;

  // Update the admin record:
  if(strlen($username) != 0) {
    $admin->updateAdmin();
    $feedback = "<span class='successmsg'>The admin details was updated successfully.</span>";
  }
  else
    $feedback = "<span class='errormsg'>ERROR: Please fill in the manditory field.</span>";

}

include_once 'layout/header.php'; 
include_once 'layout/menu.php';
?>

<h1>Update Admin Details</h1>

<?php
// Print feedback:
if ($feedback != "")
  echo "<p class='feedback'>$feedback</p>";
?>

<p><em>NOTE! If you leave the password field empty, you will keep your current password.</em></p>

<div id="container">
  <form method="post" action="update_user.php">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <div class="row">
      <div class="col-25">
        Update Username: <span style="color: red">*</span>
      </div>
      <div class="col-75">
        <input type="text" size="50" name="username" value="<?php echo $username; ?>">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        Update Password:
      </div>
      <div class="col-75">
        <input type="text" size="50" name="password">
      </div>
    </div>
    <div class="row">
      <input type="submit" value="Save">
    </div>
  </form>
</div>

<p><a href="newslist.php">Go back to news list</a></p>

<?php include_once 'layout/footer.php'; ?>