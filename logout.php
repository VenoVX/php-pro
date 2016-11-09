<?php
require_once("class/errorMessage.php");
session_start();
$error = new errorMessage();
$userName = $_SESSION['userName'];
session_unset();
session_destroy();
$error->messageLoggout($userName);

#header("Location: kleinanzeigen.html");
exit();
?>

