<?php
session_start();
require_once("facebook.php");
require_once("fbConfig.php");

$facebook = unserialize($_SESSION['fbobject']) ;
$_SESSION['fbobject'] = serialize($facebook);
$album_id = $_GET['album_id'];

$photos = $facebook->api("/{$album_id}/photos"); // get that one album
$error = ""; //error holder

//$file_folder = "c:/xampp/htdocs/Facebook/"; // folder to load files..//$zip_name = "downloadAlbum.zip";
if(extension_loaded('zip'))
{
	$zip = new ZipArchive();
	$zip_name = $album_id.".zip";
	if($zip->open($zip_name, ZIPARCHIVE::CREATE)!==TRUE)
	{
		$error .= "* Sorry ZIP creation failed at this time";
	}
	$counter = 0;
	foreach($photos['data'] as $photo)
	{
		$counter++;
		$url=$photo['source'];
	        $ch = curl_init($url);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	        $download_file = curl_exec($ch);
		$file = fopen($photo['id'].".jpg","w");
		fwrite($file,$download_file);
		fclose($file);
		$zip->addFile($photo['id'].".jpg");
	}
	$zip->close();

	foreach($photos['data'] as $photo)
	    unlink($photo['id'].".jpg");
	
	if(file_exists($zip_name))
	{
		header('Content-Description: File Transfer');
	    header('Content-Type: application/zip');
	    header('Content-Disposition: attachment; filename="'.$zip_name.'"');
	    readfile($zip_name);
		unlink($zip_name);
		exit;
	}
	else
	{	
		$error .= "* Please select file to zip ";
	}
}
else
{
	$error .= "* You dont have ZIP extension";
} 
?>
