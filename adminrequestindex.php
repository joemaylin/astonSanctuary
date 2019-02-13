<?php 

// List All Adoption Requests
include 'header.php';
require 'connect.php';

// Set Query
$query2 = "SELECT a.status as status, a.userID as userID, p.name as name, p.picture as picture from adoptions a join pets p on a.petID=p.petID";
?>

<!DOCTYPE html>
<html>
        <head>
            <title>HTML External CSS</title>
            <link rel = 'stylesheet' type = 'text/css' href = '/style.css'>
        </head>
<body>
    Historic Adoption Requests
<?php
echo '<table border="0" cellspacing="2" cellpadding="2"> 
<tr> 
    <td> <font face="Arial">Picture | </font> </td> 
    <td> <font face="Arial">Animal Name | </font> </td> 
    <td> <font face="Arial">Adoption Status | </font> </td>
    <td> <font face="Arial">User ID of requester</font> </td>  
</tr>';

if ($result = $mysqli->query($query2)) {
while ($row = $result->fetch_assoc()) {
  $field1name = "<img src='".$row["picture"]."' style=height:100px />";
  $field2name = $row["name"];
  if($row["status"] == 'u'){
    $field3name = 'Pending';
  } elseif($row["status"] == 'd'){
    $field3name = 'Denied';
  } elseif($row["status"] == 'a'){
    $field3name = 'Approved!';
  };
  $field4name = $row['userID'];

  echo "<tr> 
            <td>".$field1name."</td> 
            <td>".$field2name."</td> 
            <td>".$field3name."</td>
            <td>".$field4name."</td> 
        </tr>";
}
$result->free();
} 
?>
</body>
</html>