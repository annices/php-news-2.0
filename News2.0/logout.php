<?php

// Resume existing session:
session_start();

// Destroy current session:
unset($_SESSION['user']);

// Redirect to logged out page:
header('Location: login.php');