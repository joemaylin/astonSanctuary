<?php 
session_start();

// If the user is logged in, login text changes to edit profile (link remains the same due to profile redirect)
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    $loginout = 'Log In';
    $logref = 'login.php';
    } else{
    $loginout = 'Log Out';
    $logref = 'logout.php';
}

?>

<!DOCTYPE html>
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <meta name='description' content='' />
    <title>Aston Sanctuary</title>
    <link rel='stylesheet' href='style.css' type='text/css'>
</head>
<body>
<h1></h1>
    <div id='wrapper'>
    <div id='menu'>
        <a class='item' href='index.php'>Home</a> -
        <a class='item' href='profile.php'>View Your Profile</a> -
        <a class='item' href=<?php echo $logref ?>><?php echo $loginout ?></a>
    </div>
        <div id='content'>