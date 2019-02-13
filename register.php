<?php

require 'connect.php';
include 'header.php';
// Set up variables
$username = '';
$password = '';
$password2 = '';
$username_error = '';
$password_error = '';
$password2_error = '';

// Registration PHP
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

  // Username Validation
  if(empty(trim($_POST['username']))){
    $username_error = 'Please Enter a Username';
  } else{
    // Prep select
    $query = 'SELECT userID FROM users where username = ?';

    if($stmt = mysqli_prepare($mysqli, $query)){
      // Bind Variables to params
      mysqli_stmt_bind_param($stmt, 's', $param_username);

      // Set Params
      $param_username = trim($_POST['username']);

      // Execute
      if(mysqli_stmt_execute($stmt)){
        // Store result
        mysqli_stmt_store_result($stmt);

        if(mysqli_stmt_num_rows($stmt) == 1){
          $username_error = 'Sorry, this username is already in use';
          } else{
          $username = trim($_POST['username']);
          } 
      } else{
          echo 'Sorry, there was an error, please try again!';
      }
    }
    // Close
    mysqli_stmt_close($stmt);
  }
  // Validate Password
  if(empty(trim($_POST['password'])))
  {
    $password_error = 'Please enter a password';
    } else{
      $password = trim($_POST['password']);
    }

  // Validate Password confirmation
  if(empty(trim($_POST['password2']))){
    $password2_error = 'Please confirm password';
  } else{
      $password2 = trim($_POST['password2']);
      if (empty($password_error) && ($password != $password2)){
        $password2_error = 'Passwords do not match';
    }
  }

  // Check for errors, then insert
    if(empty($username_error) && empty($password_error) && empty($password2_error)){

      // Set up Insert
      $query = 'INSERT INTO users (username, password) VALUES (?, ?)';

      if ($stmt = mysqli_prepare($mysqli, $query)){
        // Bind Params
        mysqli_stmt_bind_param($stmt, 'ss', $param_username, $param_password);

        // Set params 
        $param_username = $username;
        // With hashed password 
        $param_password = password_hash($password, PASSWORD_DEFAULT); 

        // Execute and redirect, else error
        if(mysqli_stmt_execute($stmt)){
          header('location: login.php');
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
    <title>Sign Up</title>
    <link rel="stylesheet" href="style.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please Enter a Username and Password.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_error)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_error; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_error)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_error; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password2_error)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="password2" class="form-control" value="<?php echo $password2; ?>">
                <span class="help-block"><?php echo $password2_error; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>