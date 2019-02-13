<?php 
require 'connect.php';

$adoptid = $_GET['id'];

$query = "UPDATE adoptions SET status='a' where adoptionID=$adoptid";

// Execute
if (mysqli_query($mysqli, $query)) {
}

$archive = "UPDATE pets SET availability='1' where petID=(SELECT petID from adoptions where adoptionID='$adoptid')";

// Execute
if (mysqli_query($mysqli, $archive)) {
        mysqli_close($mysqli);
        header('Location: admin.php');
        exit;
}


?>