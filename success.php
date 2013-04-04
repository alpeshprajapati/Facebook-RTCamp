<?php
session_start();
require_once("facebook.php");
require_once("fbConfig.php");

$facebook = unserialize($_SESSION['fbobject']);
$_SESSION['fbobject'] = serialize($facebook);
$user = $facebook->getUser();
$access_token = $facebook->getAccessToken();

if ($user)
{
	$logoutUrl = $facebook->getLogoutUrl(array(
		'next'=>'http://alpeshfbapprtcamp.comuv.com/Facebook/Logout.php'
	));
} 

if ($user)
{
	try {
		// Proceed knowing you have a logged in user who's authenticated.
		$user_profile = $facebook->api('/me'); // get All user data
	}catch (FacebookApiException $e) {
		error_log($e);
		$user = null;
	}
}

$albums = $facebook->api('/me/albums');
$ArrayOfPhotoCountOfAlbum = array(); // store total number of photos of all Album

foreach($albums['data'] as $album)
{ 	
	$count = 0;
  	$photos = $facebook->api("/{$album['id']}/photos");
	
	foreach($photos['data'] as $photo)
		$count = $count + 1;
		
	$ArrayOfPhotoCountOfAlbum[] = $count; // store no. of photos in array of an album
}
?>

<html>	
<head>
	<title>Albums Page</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	<!-- Add jQuery library -->
	<script type="text/javascript" src="http://alpeshfbapprtcamp.comuv.com/Facebook/fancyBox/lib/jquery-1.9.0.min.js"></script>		
	<script type="text/javascript" src="http://alpeshfbapprtcamp.comuv.com/Facebook/fancyBox/source/jquery.fancybox.pack.js"></script>
	<script type="text/javascript" src="http://alpeshfbapprtcamp.comuv.com/Facebook/fancyBox/source/jquery.fancybox.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.fancybox').fancybox();					
		});	
	</script>
        <link rel="stylesheet" type="text/css" href="http://alpeshfbapprtcamp.comuv.com/Facebook/fancyBox/source/jquery.fancybox.css?v=2.1.4" media="screen" />
	<link rel="stylesheet" type="text/css" href="http://alpeshfbapprtcamp.comuv.com/Facebook/fb.css" media="screen" />
</head>
<body>
	<div id="logout"><a href="<?php echo $logoutUrl; ?>" style="text-decoration: none">Log Out</a><br /></div>

	<div id="divName">
		Name : <?php echo $user_profile['name'];?><br /><br>	
	</div><br>

	<?php 
                $index=0;
		
		foreach($albums['data'] as $album)
		{ 
	?>
			<a class="fancybox fancybox.iframe" href="http://alpeshfbapprtcamp.comuv.com/Facebook/albumphoto.php?album_id=<?php echo $album['id']?>" style="text-decoration: none"><img src="https://graph.facebook.com/<?=$album['id']?>/picture?type=thumbnail&access_token=<?=$access_token?>"/><br></a>
		
                  
			<a class="fancybox fancybox.iframe" href="http://alpeshfbapprtcamp.comuv.com/Facebook/albumphoto.php?album_id=<?php echo $album['id']?>" style="text-decoration: none"><?php echo $album['name'];?></a> ( <?php echo $ArrayOfPhotoCountOfAlbum[$index]." Photos ";$index += 1; ?> )<br>
		
			<a class="button" href="http://alpeshfbapprtcamp.comuv.com/Facebook/downloadAlbum.php?album_id=<?php echo $album['id']?>" >Download Album</a>
			<br><br><br>
	<?php
		}
	?>	
</body>
</html>

	