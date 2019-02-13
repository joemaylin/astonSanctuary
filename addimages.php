<?php
session_start();
include 'connect.php';


// Set variables
$id = $_SESSION['userID'];


$fileinfo=PATHINFO($_FILES["image"]["name"]);
$newFilename=$fileinfo['filename'] ."_". time() . "." . $fileinfo['extension'];
move_uploaded_file($_FILES["image"]["tmp_name"],"images/" . $newFilename);
$location="images/" . $newFilename;

mysqli_query($mysqli,"update users set picture='$location' where userID=".$id);
header('location:profile.php');

?>