<?php 
require 'connect.php'; 
include 'header.php';
$id = $_SESSION['userID'];
// Set Query
$query = "SELECT petID, name, dob, picture, dob, species, subspecies, temperment, description from pets ORDER BY dateRescued desc";

?>


<!DOCTYPE html>
<html>
        <head>
            <title>HTML External CSS</title>
            <link rel = 'stylesheet' type = 'text/css' href = '/style.css'>
        </head>
<body>

<p class = 'blue'>Below is the full list of animals listed by the date they entered the sanctuary, newest first</p>

<?php
echo '<table border="0" cellspacing="2" cellpadding="2"> 
<tr> 
    <td> <font face="Arial">Picture</font> </td> 
    <td> <font face="Arial">Animal Name</font> </td> 
    <td> <font face="Arial">Date of Birth (approximate)</font> </td> 
    <td> <font face="Arial">Species</font> </td> 
    <td> <font face="Arial">Subspecies</font> </td> 
    <td> <font face="Arial">Temperment</font> </td>
    <td> <font face="Arial">Description</font> </td>  
    <td> <font face="Arial">Adopt?</font> </td> 


</tr>';

if ($result = $mysqli->query($query)) {
while ($row = $result->fetch_assoc()) {
  $petid = $row["petID"];
  $field1name = "<img src='".$row["picture"]."' style=height:100px />";
  $field2name = $row["name"];
  $field3name = $row["dob"];
  $field4name = $row["species"];
  $field5name = $row["subspecies"];
  $field6name = $row["temperment"];
  $field7name = $row["description"];



  echo "<tr> 
            <td><a href='petdetails.php'>".$field1name."</a></td> 
            <td>".$field2name."</td> 
            <td>".$field3name."</td> 
            <td>".$field4name."</td> 
            <td>".$field5name."</td> 
            <td>".$field6name."</td> 
            <td>".$field7name."</td>
            <td><a href='adopt.php?id=".$row['petID']."'>Adopt me!</a></td> 
        </tr>";
}
$result->free();
} 
?>
</body>
</html>
