<?php 
include 'header.php';
require 'connect.php';


// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Set variables
$petid = $_GET['id'];
$id = $_SESSION['userID'];

$check = "SELECT * from adoptions where userID=$id and petID=$petid";
$query = "INSERT INTO adoptions (userID, petID) VALUES ($id, $petid)";

// Check adoption doesn't already exist
if($stmt = mysqli_prepare($mysqli, $check)){
    // Bind Variables
    mysqli_stmt_bind_param($stmt, 'ss', $param_userid, $param_petid);

    // Set Params
    $param_userid = $id;
    $param_petid = $petid;

    // Execute
    if(mysqli_stmt_execute($stmt)){
        // Store result
        mysqli_stmt_store_result($stmt);

        if(mysqli_stmt_num_rows($stmt) == 1){
            header('Location: index.php');
            exit;
        } else{
            if (mysqli_query($mysqli, $query)) {
                mysqli_close($mysqli);
                header('Location: index.php');
                exit;
            }
        }
    }
}



?>