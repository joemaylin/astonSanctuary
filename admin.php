<!-- Page allowing for Admins to add animals as well as to approve or deny Adoption requests
Admins should be able to see details about both pet and user -->

<?php 
// First - Upload new animals
include 'header.php';
require 'connect.php';

// Historical Admin Page
echo '<a href=adminindex.php>Click here to view all Current and Historic animals </a>'; 
echo '<br>';
echo '<a href=adminrequestindex.php>Click here to view all Current and Historic requests </a>';

// Check if the user is logged in as a staff member, if not then redirect to profile 
// which will redirect to login if neccesary
if($_SESSION['staff'] !== 1){
    header("location: profile.php");
    exit;
}


// Variable Setup 
$name = '';
$dob = '';
$species = '';
$subspecies = '';
$tem = '';
$desc = '';
$dayob = '';
$monthob = '';
$yearob = '';

$name_error = '';
$dob_error = '';
$species_error = '';
$subspecies_error = '';
$tem_error = '';
$desc_error = '';
$dayob_error = '';
$monthob_error = '';
$yearob_error = '';
$image_error = '';

// Upload Image
$fileinfo=PATHINFO(isset($_FILES["image"]["name"]) ? $_FILES["image"]["name"] : null);
$newFilename=$fileinfo['filename'] ."_". time() . "." . (isset($fileinfo['extension']) ? $fileinfo['extension'] : null);
move_uploaded_file((isset($_FILES["image"]["tmp_name"]) ? $_FILES["image"]["tmp_name"] : null) ,"images/" . $newFilename);
$location="images/" . $newFilename;

// Add animal PHP
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    // Field Validation
    if(empty(trim($_POST['name']))){
        $name_error = 'Please Enter a Name for the animal';
    } else{
        $name = trim($_POST['name']);
    }
    
    // Validate Year of Birth
    if(empty(trim($_POST['yearob'])) || strlen(trim($_POST['yearob'])) !== 4){
        $yearob_error = 'Please enter the animals approximate Year of Birth';
    } else{
        $yearob = trim($_POST['yearob']);
    }

    // Validate Month of Birth
    if(empty(trim($_POST['monthob'])) || strlen(trim($_POST['monthob'])) !== 2){
        $monthob_error = 'Please enter the animals approximate Month of Birth. Default to 01 if guessing only by year';
    } else{
        $monthob = trim($_POST['monthob']);
    }
    // Validate Day of Birth
    if(empty(trim($_POST['dayob'])) || strlen(trim($_POST['dayob'])) !== 2){
        $dayob_error = 'Please enter the annimals approximate Day of Birth. Default to 01 if birth date unknown';
    } else{
        $dayob = trim($_POST['dayob']);
    }

    // Check Species number isn't null
    if(empty(trim($_POST['species']))){
        $species_error = 'Please enter the animals species';
    } else{
        $species = trim($_POST['species']);
        $subspecies = trim($_POST['subspecies']);
    }  

    // Check Temperment isn't null
    if(empty(trim($_POST['tem']))){
        $tem_error = 'Please enter the animals temperment';
    } else{
        $tem = trim($_POST['tem']);
    }  

    if(empty(trim($_POST['desc']))){
        $desc_error = 'Please Enter a Description';
    } else{
        $desc = trim($_POST['desc']);
    }  


    // Check for errors, then insert
      if(empty($name_error) && empty($yearob_error) && empty($monthob_error) && empty($dayob_error) && empty($species_error) && empty($tem_error)  && empty($desc_error) && empty($image_error)){
  
        // Set up Insert
        $query = 'INSERT INTO pets (name, dob, species, subspecies, temperment, description, picture) VALUES (?, ?, ?, ?, ?, ?, ?)';
  
        if ($stmt = mysqli_prepare($mysqli, $query)){
          // Bind Params
          mysqli_stmt_bind_param($stmt, 'sssssss', $param_name, $param_dob, $param_species, $param_subspecies, $param_temperment, $param_description, $param_picture);
  
          // Set params 
          $param_name = $name;
          $param_dob = $yearob . '-' . $monthob . '-' . $dayob;
          $param_species = $species;
          $param_subspecies = $subspecies;
          $param_temperment = $tem;
          $param_description = $desc;
          $param_picture = $location;
  
          // Execute and respond, else error
          if(mysqli_stmt_execute($stmt)){
            echo 'Animal successfully registered';
          }else {
            echo 'Something went wrong, please try again later';
          }
        }
        // Close statement
        mysqli_stmt_close($stmt);
      }
      // Close connection
      mysqli_close($mysqli);
  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Animal</title>
    <link rel="stylesheet" href="style.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Add an Animal</h2>
        <p>Enter Animal Details.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="form-group <?php echo (!empty($name_error)) ? 'has-error' : ''; ?>">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="">
                <span class="help-block"><?php echo $name_error; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($yearob_error)) ? 'has-error' : ''; ?>">
                <label>Year of Birth - (YYYY)</label>
                <input type="text" name="yearob" class="form-control" value="">
                <span class="help-block"><?php echo $yearob_error; ?></span>
            </div>   
            <div class="form-group <?php echo (!empty($monthob_error)) ? 'has-error' : ''; ?>">
                <label>Month of Birth - MM</label>
                <input type="text" name="monthob" class="form-control" value="">
                <span class="help-block"><?php echo $monthob_error; ?></span>
            </div>  
            <div class="form-group <?php echo (!empty($dayob_error)) ? 'has-error' : ''; ?>">
                <label>Day of Birth - DD</label>
                <input type="text" name="dayob" class="form-control" value="">
                <span class="help-block"><?php echo $dayob_error; ?></span>
            </div>  
            <div class="form-group <?php echo (!empty($species_error)) ? 'has-error' : ''; ?>">
                <label>Species (e.g Dog)</label>
                <input type="text" name="species" class="form-control" value="">
                <span class="help-block"><?php echo $species_error; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($subspecies_error)) ? 'has-error' : ''; ?>">
                <label>Subspecies, optional (e.g Doberman)</label>
                <input type="text" name="subspecies" class="form-control" value="">
                <span class="help-block"><?php echo $subspecies_error; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($tem_error)) ? 'has-error' : ''; ?>">
                <label>Temperment (e.g Aggressive, friendly etc)</label>
                <input type="text" name="tem" class="form-control" value="">
                <span class="help-block"><?php echo $tem_error; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($desc_error)) ? 'has-error' : ''; ?>">
                <label>Description</label>
                <input type="text" name="desc" class="form-control" value="">
                <span class="help-block"><?php echo $desc_error; ?></span>
            </div>
                <div class="form-group <?php echo (!empty($image_error)) ? 'has-error' : ''; ?>">
                <label>Upload Image: </label><input type="file" name="image"> <br>
                <span class="help-block"><?php echo $image_error; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
    </div>    
</body>
</html>


<?php 
// List Adoption Requests and approve/deny them

// Set Query
$query2 = "SELECT a.adoptionID as adoptionID, u.name as name, u.tele as tele, u.bio as bio, p.petID as petID, p.picture as picture, p.name as aniname, p.dob as dob, p.temperment as tem, p.description as pdesc from adoptions a join users u ON a.userID=u.userID join pets p on a.petID=p.petID where a.status='u'";
?>

<!DOCTYPE html>
<html>
        <head>
            <title>HTML External CSS</title>
            <link rel = 'stylesheet' type = 'text/css' href = '/style.css'>
        </head>
<body>
    Current Adoption Requests
<?php
echo '<table border="0" cellspacing="2" cellpadding="2"> 
<tr> 
    <td> <font face="Arial">Picture</font> </td> 
    <td> <font face="Arial">Animal Name</font> </td> 
    <td> <font face="Arial">Date of Birth (approximate)</font> </td>  
    <td> <font face="Arial">Temperment</font> </td>
    <td> <font face="Arial">Description</font> </td>  
    <td> <font face="Arial">Person Name</font> </td> 
    <td> <font face="Arial">Telephone Number</font> </td>
    <td> <font face="Arial">Experience </font> </td>

</tr>';

if ($result = $mysqli->query($query2)) {
while ($row = $result->fetch_assoc()) {
  $field1name = "<img src='".$row["picture"]."' style=height:100px />";
  $field2name = $row["aniname"];
  $field3name = $row["dob"];
  $field4name = $row["tem"];
  $field5name = $row["pdesc"];
  $field6name = $row["name"];
  $field7name = $row["tele"];
  $field8name = $row["bio"];



  echo "<tr> 
            <td>".$field1name."</td> 
            <td>".$field2name."</td> 
            <td>".$field3name."</td> 
            <td>".$field4name."</td> 
            <td>".$field5name."</td> 
            <td>".$field6name."</td> 
            <td>".$field7name."</td>
            <td>".$field8name."</td>
            <td><a href='approve.php?id=".$row['adoptionID']."'>Approve!</a></td> 
            <td><a href='deny.php?id=".$row['adoptionID']."'>Deny!</a></td> 
        </tr>";
}
$result->free();
} 
?>
</body>
</html>