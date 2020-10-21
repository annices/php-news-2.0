<?php
session_start();
// If admin is not logged in:
if (!isset($_SESSION['user'])) {
  // Redirect to login page:
  header('Location: login.php');
}

// Files needed to connect to database:
include_once 'config/database.php';
include_once 'objects/news.php';

// Connect to database:
$database = new Database();
$db = $database->getConnection();

// Create URL parameter to edit specific entry by its ID:
$id = $_GET['id'];

// Instantiate news object:
$news = new News($db);

// Assign object property to match URL parameter:
$news->id = $id;

// If matching record ID is successfully fetched from database:
if($news->getNewsById()) {

  // Assign variables with fetched object property values:
  $id = $news->{'id'};
  $subject = $news->{'subject'};
  $created = $news->{'created'};
  $entry = $news->{'entry'};

}
else
  $feedback = "<span class='errormsg'>ERROR: Could not get record ID.</span>";


// If update:
if($_POST['update']) {

  $id = $_POST['id'];
  $subject = $_POST['subject'];
  $created = $_POST['created'];
  $entry = $_POST['entry'];

  // Assign news property values:
  $news->id = $id;
  $news->subject = $subject;
  $news->created = $created;
  $news->entry = $entry;

  // Update the news record:
  if(strlen($subject) != 0 && strlen($entry) != 0 && $news->validateDate($created)) {
    $news->updateNews();
    $feedback = "<span class='successmsg'>Your entry was updated successfully.</span>";
  }
  else if(!$news->validateDate($created))
    $feedback = "<span class='errormsg'>ERROR: Please type a valid date format, e.g. '2019-03-20 09:20'.</span>";
  else
    $feedback = "<span class='errormsg'>ERROR: Please fill in the manditory fields.</span>";

}

// If delete:
if($_POST['delete']) {

  $id = $_POST['id'];

  // Assign news property values:
  $news->id = $id;

  // Update the news record:
  if($news->deleteNews()) {

    $_SESSION['feedback'] = "<span class='successmsg'>Your entry was successfully deleted.</span>";
    header("Location: newslist.php");
  }
  else
    $feedback = "<span class='errormsg'>ERROR: The entry could not be deleted.</span>";

}

include_once 'layout/header.php';
include_once 'layout/menu.php';
?>

<h1>Edit News</h1>

<?php
// Print feedback:
if ($feedback != "")
  echo "<p class='feedback'>$feedback</p>";
?>

<div id="container">
  <form method="post" action="update_news.php?id=$id">
    <input type="hidden" name="id" value="<?php echo $id; ?>">
    <div class="row">
      <div class="col-25">
        News Title: <span style="color: red">*</span>
      </div>
      <div class="col-75">
        <input type="text" size="50" name="subject" value="<?php echo $subject; ?>">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        News Date: <span style="color: red">*</span>
      </div>
      <div class="col-75">
        <input type="text" size="50" name="created" value="<?php echo $created; ?>">
      </div>
    </div>
    <div class="row">
      <div class="col-25">
        News Entry: <span style="color: red">*</span>
      </div>
      <div class="col-75">
        <textarea name="entry" cols="60" rows="10"><?php echo $entry; ?></textarea>
        <p><em>It is allowed to use HTML and CSS code in the entry field for text styling.<br>
          E.g.: &lt;b&gt;Bold text&lt;/b&gt; &lt;em&gt;Italic text&lt;/em&gt;</em></p>
        </div>
      </div>
      <div class="row">
       <input type="submit" name="update" value="Save"> <input type="submit" name="delete" value="Delete">
     </div>
   </form>

 </div>

 <p><a href="newslist.php">Go back to news list</a></p>

 <?php include_once 'layout/footer.php'; ?>