<?php

$localhost = 'localhost';
$username = 'root';
$password = '';
$database = 'astonsanctuary';

$mysqli = new mysqli($localhost, $username, $password, $database);
if ($mysqli->connect_errno) {
    echo 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
}
// echo $mysqli->host_info . '\n';
?>