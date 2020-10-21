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
include_once 'objects/pagination.php';

// Connect to database:
$database = new Database();
$db = $database->getConnection();

// Instantiate news object:
$news = new News($db);

// Assign object property to match URL parameter:
$news->id = $id;

// If matching record ID is successfully fetched from database:
if($news->getNewsById()) {

  	// Assign variables with fetched object property values:
	$id = $news->{'id'};
	$subject = $news->{'subject'};
	$entry = $news->{'entry'};

}
else
	$feedback = "<span class='errormsg'>ERROR: Could not get record ID.</span>";

// Delete the news record:
if(isset($_POST['delete'])) {
	$news->id = $_POST['id'];
	$news->deleteNews();
	$feedback = "<span class='successmsg'>The news record was successfully deleted.</span>";
}
else
	$feedback = "<span class='errormsg'>ERROR: The news record could not be deleted.</span>";

include_once 'layout/header.php';
include_once 'layout/menu.php';
?>

<h1>Edit News</h1>

<p>
	<?php
	// Catch feedback msg from created news page:
	$feedback = $_SESSION['feedback'];

	// Destroy session to make sure the feedback msg is removed on next server request:
	unset($_SESSION['feedback']);
	echo $feedback;
	?>
</p>

<table>
	<thead>
		<tr>
			<th><b>Subject</b></th>
			<th><b>Created</b></th>
			<th><b>Entry</b></th>
			<th><b>Manage News</b></th>
		</tr>
	</thead>
	<tbody>

		<?php

		// Instantiate news object:
		$news = new News($db);

		// Instantiate pagination object:
		$pagination = new Pagination($db);

		// Fetch number of total entries in database:
		$numrows = $pagination->getTotalRows();

		// Fetch entries to display per page (default = 20, can be changed in object class).
		$rowsperpage = $pagination->getRowsPerPage();

		// Fetch total pages to work with for pagination:
		$totalpages = $pagination->getTotalPages($numrows, $rowsperpage);

		// Get the current page or set a default:
		if (isset($_GET['page']))
			$currentpage = (int) $_GET['page'];
		else 
			$currentpage = 1;

		// Call method to control page range navigation:
		$offset = $pagination->checkPageRange($currentpage, $totalpages, $rowsperpage);

		if($numrows > 0) {

			// Fetch and print the latest entries from database:
			foreach ($news->getNews($offset, $rowsperpage, null) as $item) {

				$id = $item['id'];

				$entry = $item['entry'];
				// If entry length is too long, cut string to display 50 first characters:
				if(strlen($entry) > 50) { 
					$entry =  substr($entry, 0, 50)."...";
				}

				// Prepare DateTime object to use for formatting the date as wanted:
				$date = date_create($item['created']);

				echo "<tr>";
				echo "<td>" .$item['subject'] . "</td>";
				echo "<td>" .date_format($date,"Y-m-d H:i"). "</td>"; 
				echo "<td>" .$entry. "</td>";
				echo "<td>";
				echo "<a href='update_news.php?id=$id'>Edit</a> | ";
				echo "<form method='post' action='newslist.php' style='display: inline-block' onsubmit='return confirm(\"Are you sure you want to delete this entry?\")'><input type='hidden' name='id' value='$id'>";
				echo "<input type='submit' name='delete' value='Delete' class='submit'>";
				echo "</td>";
				echo "</tr>";
				echo "</form>";

			}

		}
		else
			echo "<tr><td colspan='4'><em>No entries to show...</em></td></tr>";
		?>

	</tbody>
</table>

<?php include_once 'layout/paginationlinks.php'; ?>

<?php include_once 'layout/footer.php'; ?>