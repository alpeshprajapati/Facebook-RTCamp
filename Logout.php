<?php
require_once("facebook.php");
require_once("fbConfig.php");

$facebook = new Facebook($config);
$facebook->destroySession(); // expiring session
header('Location: http://alpeshfbapprtcamp.comuv.com/Facebook/Login.php'); // Take him to login page after logging out
?>