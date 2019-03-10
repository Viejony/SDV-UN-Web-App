/* Destroy current user session */
<?php
session_start();
session_unset($_SESSION['email']);
session_destroy();
$_SESSION['loggedin'] = false;
header('location: index.php');
?>