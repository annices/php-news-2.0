<?php
session_start();

// If username session is not set:
if (!isset($_SESSION['user'])) {
// Redirect to login page:
	header('Location: login.php');
}

// Files needed to connect to database:
include_once 'config/database.php';
include_once 'objects/news.php';

// Create date format with local time. Add or remove hours to suit your local time:
$date = date('Y-m-d H:i', strtotime($date . "+ 1 hour"));


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	// Connect to database:
	$database = new Database();
	$db = $database->getConnection();

	// Submit data:
	$subject = $_POST['subject'];
	$date = $_POST['created'];
	$entry = $_POST['entry'];

	// Instantiate news object:
	$news = new News($db);

	// Set news property values:
	$news->subject = $subject;
	$news->created = $date;
	$news->entry = $entry;

	if(strlen($subject) != 0 && strlen($entry) != 0 && $news->validateDate($date)) {
		// Create the news:
		$news->createNews();
		$_SESSION['feedback'] = "<span class='successmsg'>The entry was saved successfully.</span>";
		header("Location: newslist.php");
	}
	else if(!$news->validateDate($date))
		$feedback = "<span class='errormsg'>ERROR: Please type a valid date format, e.g. '2019-03-20 09:20'.</span>";
	else
		$feedback = "<span class='errormsg'>ERROR: Please fill in the manditory fields.</span>";

}

include_once 'layout/header.php';
include_once 'layout/menu.php';
?>

<h1>Create News</h1>

<?php
    // Print out db feedback:
if ($feedback != "") {
	echo "<p class='feedback'>$feedback</p>";
}
?>

<div id="container">
	<form method="post" action="create_news.php">
		<div class="row">
			<div class="col-25">
				News title: <span style="color: red">*</span>
			</div>
			<div class="col-75">
				<input name="subject" type="text" size="50">
			</div>
		</div>
		<div class="row">
			<div class="col-25">
				News Date: <span style="color: red">*</span>
			</div>
			<div class="col-75">
				<input name="created" type="text" size="50" value="<?php echo $date; ?>">
			</div>
		</div>
		<div class="row">
			<div class="col-25">
				News entry: <span style="color: red">*</span>
			</div>
			<div class="col-75">
				<textarea name="entry" maxlength="1000" rows="10" cols="60"></textarea>
				<p><em>It is allowed to use HTML and CSS code in the entry field for text styling.<br>
					E.g.: &lt;b&gt;Bold text&lt;/b&gt; &lt;em&gt;Italic text&lt;/em&gt;</em></p>
				</div>
			</div>
		</div>
		<div class="row">
			<input type="submit" value="Save">
		</div>
	</form>
</div>


<p><a href="newslist.php">Go back to news list</a></p> 

<?php include_once 'layout/footer.php'; ?>