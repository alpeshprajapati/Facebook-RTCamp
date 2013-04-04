<?php
session_start();
require_once("facebook.php");
require_once("fbConfig.php");

$facebook = new Facebook($config);
$user = $facebook->getUser(); // Get User Id

// Login or logout url will be needed depending on current user state.
if ($user) // Logged in
{
	$_SESSION['fbobject'] = serialize($facebook); // Taking object in session for api requests
        header('Location: http://alpeshfbapprtcamp.comuv.com/Facebook/success.php'); // Take him to this page
}
else
{
	$params = array(
		'scope' => 'user_photos, offline_access'
	);
	$loginUrl = $facebook->getLoginUrl($params);
}
?>

<html>
<head>
	<title>Facebook Login Page</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="http://alpeshfbapprtcamp.comuv.com/Facebook/fb.css" media="screen" />
</head>
<body>
	<h2 align="center"> This application lets you access and download your facebook albums.</h2>
	<a href="<?php echo $loginUrl; ?>"><img id="fbimg" src="facebook-icon.jpg"/></a>		
	<h4>Developed by Alpesh Prajapati.</h4>
</body>
</html>
 

			