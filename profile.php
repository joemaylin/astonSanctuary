<!-- This page is for Users to update their profile Information
There should be entry boxes for: Name, Address, Biography/Animal Exp, Profile Picture And Telephone Number
Hitting update should update the User Table in the database with the given information -->

<?php
// Initialize the session
require 'connect.php';
include 'header.php';

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
 } elseif($_SESSION['staff'] === 1){
    // If user is a staff member, redirect to the admin page
    header("location: admin.php");
    exit;
}

// Set up variables
$id = $_SESSION['userID'];
$name = $_SESSION['name'];
$address = $_SESSION['address'];
$dob = $_SESSION['dob'];
$picture = $_SESSION['picture'];
$tele = $_SESSION['tele'];
$bio = $_SESSION['bio'];
$dayob = substr($dob, 8, 2);
$monthob = substr($dob, 5, 2);
$yearob = substr($dob, 0, 4);


$name_error = '';
$add_error = '';
$dob_error = '';
$tele_error = '';
$bio_error = '';
$dayob_error = '';
$monthob_error = '';
$yearob_error = '';
$image_error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    // Check name isn't null
    if(empty(trim($_POST['name']))){
        $name_error = 'Please enter your name.';
    } else{
        $name = trim($_POST['name']);
    }

    // Check address isn't null
    if(empty(trim($_POST['address']))){
        $add_error = 'Please enter your address.';
    } else{
        $address = trim($_POST['address']);
    }

    // Validate Year of Birth
    if(empty(trim($_POST['yearob'])) || strlen(trim($_POST['yearob'])) !== 4){
        $yearob_error = 'Please enter your Year of birth in fromat YYYY.';
    } else{
        $yearob = trim($_POST['yearob']);
    }

    // Validate Month of Birth
    if(empty(trim($_POST['monthob'])) || strlen(trim($_POST['monthob'])) !== 2){
        $monthob_error = 'Please enter your Month of Birth in format MM.';
    } else{
        $monthob = trim($_POST['monthob']);
    }
    // Validate Day of Birth
    if(empty(trim($_POST['dayob'])) || strlen(trim($_POST['dayob'])) !== 2){
        $dayob_error = 'Please enter your Day of Birth in format DD.';
    } else{
        $dayob = trim($_POST['dayob']);
    }

    // Check Telephone number isn't null
    if(empty(trim($_POST['tele']))){
        $tele_error = 'Please enter your Telephone number so that we can contact you.';
    } else{
        $tele = trim($_POST['tele']);
    }  

    // Check Biography isn't null
    if(empty(trim($_POST['bio']))){
        $bio_error = 'Please enter some information about your animal experience. This is important for matching you with a suitable animal.';
    } else{
        $bio = trim($_POST['bio']);
    }  

    // Check for errors, then update 
    if(empty($name_error) && empty($add_error) && empty($yearob_error) && empty($monthob_error) && empty($dayob_error) && empty($tele_error) && empty($bio_error)){
        
        // Set up Update
        $query = 'UPDATE users SET name=?, address=?, dob=?, tele=?, bio=? where users.userID=?';

        if ($stmt = mysqli_prepare($mysqli, $query)){
            // Bind Params
            mysqli_stmt_bind_param($stmt, 'ssssss', $param_name, $param_add, $param_dob, $param_tele, $param_bio, $param_userID);

            // Set params 
            $param_name = $name;
            $param_add = $address;
            $param_dob = $yearob . '-' . $monthob . '-' . $dayob;
            $param_tele = $tele;
            $param_bio = $bio;
            $param_userID = $id;


            // Execute and Respond, else error
            if(mysqli_stmt_execute($stmt)){
                echo 'Profile successfully updated!';
            } else{
                echo 'Something went wrong, please try again';
            }


        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
    // Close Connection
    mysqli_close($mysqli);
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile Page</title>
    <link rel="stylesheet" href="style.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Profile</h2>
        <p>Update your details here.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($name_error)) ? 'has-error' : ''; ?>">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $name ?>">
                <span class="help-block"><?php echo $name_error; ?></span>
            </div> <br>
            <div class="form-group <?php echo (!empty($add_error)) ? 'has-error' : ''; ?>">
                <label>Address</label>
                <input type="text" name="address" class="form-control" value="<?php echo $address ?>">
                <span class="help-block"><?php echo $add_error; ?></span>
            </div>   <br> 
            <div class="form-group <?php echo (!empty($yearob_error)) ? 'has-error' : ''; ?>">
                <label>Year of Birth - YYYY</label>
                <input type="text" name="yearob" class="form-control" value="<?php echo $yearob ?>">
                <span class="help-block"><?php echo $yearob_error; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($monthob_error)) ? 'has-error' : ''; ?>">
                <label>Month of Birth - MM</label>
                <input type="text" name="monthob" class="form-control" value="<?php echo $monthob ?>">
                <span class="help-block"><?php echo $monthob_error; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($dayob_error)) ? 'has-error' : ''; ?>">
                <label>Day of Birth - DD</label>
                <input type="text" name="dayob" class="form-control" value="<?php echo $dayob ?>">
                <span class="help-block"><?php echo $dayob_error; ?></span>
            </div>   <br>
            <div class="form-group <?php echo (!empty($tele_error)) ? 'has-error' : ''; ?>">
                <label>Telephone Contact Number</label>
                <input type="text" name="tele" class="form-control" value="<?php echo $tele ?>">
                <span class="help-block"><?php echo $tele_error; ?></span>
            </div> <br>
            <div class="form-group <?php echo (!empty($bio_error)) ? 'has-error' : ''; ?>">
                <label>Biography, Please specify history and experience with animals.</label>
                <input type="text" name="bio" class="form-control" value="<?php echo $bio ?>">
                <span class="help-block"><?php echo $bio_error; ?></span>
            </div>   <br>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Update">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
        </form>
        <br><br><br><br>
        <form enctype="multipart/form-data" action="addimages.php" method="POST"> 
        <div>Current Image:
	    <?php
		include('connect.php');
        $query=mysqli_query($mysqli,"select picture from users where userID=".$id);
		while($row=mysqli_fetch_array($query)){
			?>
				<img src="<?php echo $row['img_location']; ?>">
			<?php
		}?>
	    </div>
        <div>
        <label>Upload New Image: </label><input type="file" name="image"> <br>
        <button type="submit">Upload</button>
        </form>
        </div>
    </div>
    
<!-- Show adoption requests here -->

<?php 
// List Personal Adoption Requests

// Set Query
$query2 = "SELECT a.status as status, p.name as name, p.picture as picture from adoptions a join pets p on a.petID=p.petID where a.userID=$id";
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
    <td> <font face="Arial">Name</font> </td> 
    <td> <font face="Arial">Adoption Status</font> </td>  
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

  echo "<tr> 
            <td>".$field1name."</td> 
            <td>".$field2name."</td> 
            <td>".$field3name."</td> 
        </tr>";
}
$result->free();
} 
?>
</body>
</html>