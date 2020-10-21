<?php 
session_start();

include_once 'layout/header.php';

// Check if admin is logged in:
if (isset($_SESSION['user'])) {
	// If so, show menu:
	include_once 'layout/menu.php';
}
?>

<h1>Start</h1>

<div id="container">

	<?php include_once 'news_entries.php'; ?>

</div>

<?php include_once 'layout/footer.php'; ?>