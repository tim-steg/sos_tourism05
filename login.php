<?php 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once("db.php");
    session_start();
    $msg = "";

    if (isset($_SESSION['authuser'])) {
        // if user is logged in already, redirect them.
        header("Location: ./my-events.php?id=".$_SESSION['userid']);
    }

    if (isset($_POST['loginattempt'])) {
        $dbcon = new dbConnect();
        $dbcon->connectToDB();

        
        if (isset($_POST['username']) && isset($_POST['password']) &&
            $dbcon->checkLogin($_POST['username'], $_POST['password']) == true) {

            $_SESSION['userid'] = $dbcon->getUserID($_POST['username']);
            $_SESSION['authuser'] = true;
            header("Location: ./my-events.php?id=".$_SESSION['userid']);
        } else {
            $msg = "Error: Invalid Login Credentials.";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/log-in.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
   
    <title>Login</title>
</head>
<body>
    <div class="right">
        <h1>Login</h1>
        <p class="hint1">Enter your information below</p>
        <form method="POST" action="./login.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" style="margin-bottom: 10px;" name="loginattempt">Login</button>
            <p style="color: red; margin-top: 0px; font-style: italic;
                    margin-bottom: 10px; font-size: 22px; font-weight: 700;"><?php echo $msg; ?></p> 
            <p class="hint2">Don't have an account? <a href="sign-up.php">Sign up</a></p>
          
        </form>
    </div>
    <div class="left">
        <img src="./res/Logo.png" alt="" srcset="">
        <h1>Log in!</h1>
        <p>Login to your account now and start planning your event safely!</p>
    </div>
</body>
</html>