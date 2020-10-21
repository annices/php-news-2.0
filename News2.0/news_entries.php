<?php

// Files needed to connect to database:
include_once 'config/database.php';
include_once 'objects/news.php';
include_once 'objects/pagination.php';

// Connect to database:
$database = new Database();
$db = $database->getConnection();

// Instantiate news object:
$news = new News($db);

// Instantiate pagination object:
$pagination = new Pagination($db);

// Fetch number of total entries in database:
$numrows = $pagination->getTotalRows();

if($numrows > 0) {

	// Fetch and print the 10 latest records from database (can be changed to whatever number of records you prefer):
	foreach ($news->getNews(null, null, 10) as $item) {

		// Prepare DateTime object to use for formatting the date as wanted:
		$date = date_create($item['created']);

		echo "<p><b>" .$item['subject']. "</b> (" .date_format($date,"Y-m-d H:i"). ")"; 
		echo "<p>" .nl2br($item['entry']). "</p></p>";
		
		if($numrows > 1)
			echo "<hr class='dotted'>";

	}

}
else
	echo "<em>When news are created, the 10 latest news will be displayed here for visitors.</em>"

?>