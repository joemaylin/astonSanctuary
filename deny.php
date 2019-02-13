<?php 
require 'connect.php';

$adoptid = $_GET['id'];

$query = "UPDATE adoptions SET status='d' where adoptionID=$adoptid";

// Execute
if (mysqli_query($mysqli, $query)) {
        mysqli_close($mysqli);
        header('Location: admin.php');
        exit;
}


?>