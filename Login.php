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

	<!--<link rel="stylesheet" type="text/css" href="http://alpeshfbapprtcamp.comuv.com/Facebook/fb.css" media="screen" />-->
        
        <link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">	
	<link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
	<link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="bootstrap/css/myBootstrap.css" rel="stylesheet">

</head>
<body>
	<h3 align="center"> This application lets you access and download your facebook albums.</h3>
	<a href="<?php echo $loginUrl; ?>" class="btn btn-primary fbconnect">Connect with Facebook</a>		
	<h4 id="author">Developed by Alpesh Prajapati.</h4>

        <script src="http://code.jquery.com/jquery.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
 

			