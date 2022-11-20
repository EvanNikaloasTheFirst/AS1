<?php
session_start();
$title = "Log Out";
require 'layout.php';

unset($_SESSION['loggedIn']);
unset($_SESSION['firstname']);
unset($_SESSION['email']);

unset($_SESSION['admin_email']);
unset($_SESSION['adminLoggedIn']);




$_SESSION['loggedIn'] = false;
echo 'Logged out';
echo '<p>'.'<a href="login.php">Log in</a>'.'</p>';
?>