<?php
// Initialize the session
require 'connect.php';

// Check if the user is already logged in, if yes then redirect to profile page
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
    header('location: profile.php');
    exit;
}
 
// Initialise variables

$username = '';
$password = '';
$username_error = '';
$password_error = '';
 
if($_SERVER['REQUEST_METHOD'] == 'POST'){
 
    // Check username isn't null
    if(empty(trim($_POST['username']))){
        $username_error = 'Please enter username.';
    } else{
        $username = trim($_POST['username']);
    }
    
    // Check password isn't null
    if(empty(trim($_POST['password']))){
        $password_error = 'Please enter your password.';
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate credentials
    if(empty($username_error) && empty($password_error)){
        // Prepare select
        $query = 'SELECT userID, username, password, name, address, dob, picture, tele, staff, bio FROM users WHERE username = ?';
        
        if($stmt = mysqli_prepare($mysqli, $query)){
            // Bind variables
            mysqli_stmt_bind_param($stmt, 's', $param_username);
            $param_username = $username;
            
            // Execute and Store result
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                // Check username is in database
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind resulting variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $name, $address, $dob, $picture, $tele, $staff, $bio);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // If password matches username, start new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION['loggedin'] = true;
                            $_SESSION['userID'] = $id;
                            $_SESSION['username'] = $username;
                            $_SESSION['name'] = $name;
                            $_SESSION['address'] = $address;
                            $_SESSION['dob'] = $dob;
                            $_SESSION['picture'] = $picture;
                            $_SESSION['tele'] = $tele;
                            $_SESSION['staff'] = $staff;
                            $_SESSION['bio'] = $bio;
                            
                            // Redirect user to profile
                            header('location: profile.php');
                        } else{
                            // Display error message if password is not valid
                            $password_error = 'The password you entered was not valid.';
                        }
                    }
                } else{
                    // Display error message if username doesn't exist
                    $username_error = 'No account found with that username.';
                }
            } else{
                echo 'Oops! Something went wrong. Please try again later.';
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
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>Login</title>
    <link rel='stylesheet' href='style.css'>
    <style type='text/css'>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
</head>
<body>
<h1></h1>
    <div id='wrapper'>
    <div id='menu'>
        <a class='item' href='index.php'>Home</a>
    </div>
        <div id='content'>
    <div class='wrapper'>
        <h2>Login</h2>
        <p>Enter Username and Password to log in.</p>
        <form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='post'>
            <div class='form-group <?php echo (!empty($username_error)) ? 'has-error' : ''; ?>'>
                <label>Username</label>
                <input type='text' name='username' class='form-control' value='<?php echo $username; ?>'>
                <span class='help-block'><?php echo $username_error; ?></span>
            </div>    
            <div class='form-group <?php echo (!empty($password_error)) ? 'has-error' : ''; ?>'>
                <label>Password</label>
                <input type='password' name='password' class='form-control'>
                <span class='help-block'><?php echo $password_error; ?></span>
            </div>
            <div class='form-group'>
                <input type='submit' class='btn btn-primary' value='Login'>
            </div>
            <p>Don't have an account? <a href='register.php'>Sign up now</a>.</p>
        </form>
    </div>    
</body>
</html>